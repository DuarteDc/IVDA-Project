<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\AdministrativeUnitInventorySubsecretary;
use App\models\DependencyInventory;
use App\models\Inventory;
use PDOException;

class InventoryController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;
        $data = Inventory::find($page);
        $this->response(['inventories' => $data['inventories'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function getInventoriesByUser()
    {
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;
        $data = Inventory::findByUser($page, $this->auth()->id);
        $this->response(['inventories' => $data['inventories'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function save()
    {

        $code = $this->post('code');
        $administrative_unit_id = $this->post('administrative_unit_id');
        $subsecretary_id = $this->post('subsecretary_id');

        if (!$code || !$administrative_unit_id || !$subsecretary_id) return $this->response(['message' => 'Los campos son requeridos'], 400);

        $inventory = AdministrativeUnitInventorySubsecretary::Where("administrative_unit_id = '$administrative_unit_id' AND subsecretary_id = '$subsecretary_id'");
        if ($inventory && !Inventory::findOne($inventory->inventory_id)->status) return $this->response(['message' => 'Ya existe un inventario en proceso con esa unidad administrativa'], 400);

        $name = 'INVENTARIO GENERAL DE ARCHIVO';
        $inventory = new Inventory();
        $newInventory = $inventory->save($name, $code, $this::auth()->id);
        if (!$newInventory) return $this->response(['message' => 'Parece que hubo un error al crear el inventario'], 400);

        $this->attachInventoryData($administrative_unit_id, $newInventory->id, $subsecretary_id);

        $this->response(['message' => 'El inventario se creo con exito']);
    }

    public function update(string $id)
    {
        $code = $this->post('code');
        $administrative_unit_id = $this->post('administrative_unit_id');
        $subsecretary_id = $this->post('subsecretary_id');

        if (empty($code) && empty($administrative_unit_id) && empty($subsecretary_id)) return $this->response(['message' => 'El inventario se actualizó correctamente']);

        $inventory = AdministrativeUnitInventorySubsecretary::Where("id = $id");
        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible']);

        if ($inventory->administrative_unit_id != $administrative_unit_id || $inventory->$subsecretary_id != $subsecretary_id) {
            if (!empty(json_decode($inventory->body))) return $this->response(['message' => 'El inventario no se puede actualizar porque ya cuenta con archivos agregados'], 400);
        }

        $inventory->UpdateOne($id, ['administrative_unit_id' => $administrative_unit_id, 'subsecretary_id' => $subsecretary_id]);

        $inventory = Inventory::UpdateOne($inventory->inventory_id, ['code' => $code]);

        $this->response(['message' => 'El inventario se creo con exito']);
    }

    public function show(string $id)
    {
        $inventory = Inventory::findOne($id);
        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);
        $inventory = AdministrativeUnitInventorySubsecretary::Where("inventory_id = {$inventory->id}");
        $inventory->body = json_decode($inventory->body ?? "[]");
        $this->response(['inventory' => $inventory->getDataRelations($inventory)]);
    }

    public function getInventoryByUser()
    {
        $administrative_unit_id = self::auth()->administrative_unit_id;
        $inventory = AdministrativeUnitInventorySubsecretary::Where("administrative_unit_id = $administrative_unit_id");
        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 404);
        $inventory = $inventory->getDataRelations($inventory);
        if ($inventory->inventory_id->status) return $this->response(['message' => 'El inventario ya ha sido finalizado'], 400);
        $inventory->body = json_decode($inventory->body ?? "[]");
        $this->response(['inventory' => $inventory]);
    }

    public function addFile(string $id)
    {
        $inventory = Inventory::findOne($id);
        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);

        $inventory_body = AdministrativeUnitInventorySubsecretary::Where("inventory_id = {$inventory->id}");

        if (!$inventory_body) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);

        $body = $this->addNewFile($inventory_body->body, $this->request());
        $updated = $inventory_body->updateBody($inventory_body->id, $body);
        return $updated ? $this->response(['message' => 'El archivo se guardo correctamente']) :  $this->response(['message' => 'Parece que hubo un error al guardar el archivo'], 400);
    }

    public function deleteFile(string $id, string $no_file)
    {
        $inventory = Inventory::findOne($id);
        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);

        $inventory_body = AdministrativeUnitInventorySubsecretary::Where("inventory_id = {$inventory->id}");

        if (!$inventory_body) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);

        if (!$this->existFile($no_file, $inventory_body->body)) return $this->response(['message' => 'El archivo no existe o ya ha sido eliminado'], 400);

        $newBody = $this->removeFile($no_file, $inventory_body->body);

        $inventory_body->updateBody($inventory_body->id, json_encode($newBody));

        $this->response(['message' => 'El archivo se elimino correctamente']);
    }


    public function finalizeInventory(string $id)
    {
        $inventory = Inventory::findOne($id);
        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);
        if ($inventory->status) return $this->response(['message' => 'El inventario ya ha sido finalizado'], 400);
        $inventory->UpdateOne($id, ['status' => true]);
        $this->response(['message' => 'El inventario se finalizo correctamenet']);
    }

    private function addNewFile($body, $file)
    {
        if (empty($body)) {
            $body = [];
            $file = [...$file, 'no' => 1];
            array_push($body, $file);
        } else {
            $body = json_decode($body);
            $file = [...$file, 'no' => count($body) + 1];
            array_push($body, $file);
        }

        return json_encode($body);
    }

    private function removeFile($no_file, $body)
    {
        $body = json_decode($body);
        $newBody = array_filter($body, fn ($file) => $file->no != $no_file, 1);

        return array_map(
            function ($file, $index) {
                $file->no = $index + 1;
                return $file;
            },
            $newBody,
            array_keys(array_keys($newBody))
        );
    }

    private function existFile(string $no_file, $body)
    {
        if (empty($body)) return false;
        $body = json_decode($body);
        $exist = array_filter($body, fn ($file) => $file->no == $no_file);
        return count($exist) == 1;
    }

    private function attachInventoryData(string $administrative_unit_id, string $inventory_id, string $subsecretary_id)
    {
        try {
            return AdministrativeUnitInventorySubsecretary::save($administrative_unit_id, $inventory_id, $subsecretary_id);
        } catch (PDOException $e) {
            $this->response(['message' => $e->getMessage()]);
        }
    }
}
