<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\Dependency;
use App\models\DependencyInventoryLocationTypeFile;
use App\models\Inventory;
use App\models\Location;
use App\models\TypeFile;
use App\models\User;
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

        array_map(function ($inventory) {
            $inventory->dependency_id = Dependency::findOne(DependencyInventoryLocationTypeFile::Where("inventory_id = $inventory->id")->dependency_id);
        }, $data['inventories']);

        $this->response(['inventories' => $data['inventories'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function getInventoriesByUser()
    {
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;
        $data = Inventory::findByUser($page, $this->auth()->id);

        array_map(function ($inventory) {
            $inventory->dependency_id = Dependency::findOne(DependencyInventoryLocationTypeFile::Where("inventory_id = $inventory->id")->dependency_id);
        }, $data['inventories']);
        $this->response(['inventories' => $data['inventories'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }


    private function validateNewLocation($location)
    {
        if (gettype($location) === "integer") {
            $getLocation = Location::findOne($location);
            if (!$getLocation) return $this->response(['message' => 'El tipo de archivo no existe o no es valido'], 400);
            return $getLocation;
        }
        $name = trim(ucwords($location));
        $location = Location::where("name = '$name'");
        if ($location) return $location;
        $newLocation = new Location();
        return $newLocation->save($name);
    }


    private function validateNewTypeFile($typeFile)
    {
        if (gettype($typeFile) === "integer") {
            $getTypeFile = TypeFile::findOne($typeFile);
            if (!$getTypeFile) return $this->response(['message' => 'El tipo de archivo no existe o no es valido'], 400);
            return $getTypeFile;
        }
        $name = trim(ucwords($typeFile));
        $typeFile = TypeFile::where("name = '$name'");
        if ($typeFile) return $typeFile;
        $newFileType = new TypeFile();
        return $newFileType->save($name);
    }

    public function save()
    {

        $inventory = Inventory::Where("user_id = {$this->auth()->id} AND status = false");
        if ($inventory) return $this->response(['message' => 'No es posible crear un nuevo inventario porque actualmente hay un inventario en curso'], 400);

        $typeFile = $this->post('type_file');
        $location = $this->post('location');
        $date = $this->post('date');

        if (!$typeFile || !$location || !$date) return $this->response(['message' => 'Los campos son requeridos'], 400);

        if (gettype($typeFile) === "string" && is_numeric($typeFile)) return $this->response(['message' => 'Por favor ingresa un nombre valido para crear un tipo de archivo'], 400);
        if (gettype($location) === "string" && is_numeric($location)) return $this->response(['message' => 'Por favor ingresa un nombre valido para crear una ubicación'], 400);

        $newTypeFile = $this->validateNewTypeFile($typeFile);
        $newLocation = $this->validateNewLocation($location);

        $inventory = new Inventory();

        $inventory = $inventory->save($this->auth()->id, $date);
        $inventory->attachData($this->auth()->dependency_id, $inventory->id, $newLocation->id, $newTypeFile->id);

        $this->response(['message' => 'El inventario se creo con exito', 'inventory_id' => $inventory->id], 200);
    }

    public function update(string $id)
    {
        $typeFile = $this->post('type_file');
        $location = $this->post('location');
        $date = $this->post('date');

        $inventory = DependencyInventoryLocationTypeFile::Where("id = $id");
        if (Inventory::findOne($inventory->inventory_id)->user_id !== $this->auth()->id) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);
        if (empty($typeFile) && empty($location) && empty($date)) return $this->response(['message' => 'El inventario se actualizó correctamente']);

        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);

        $newTypeFile = $this->validateNewTypeFile($typeFile);
        $newLocation = $this->validateNewLocation($location);

        $inventory->UpdateOne($id, ['type_file_id' => $newTypeFile->id, 'location_id' => $newLocation->id]);

        $inventory = Inventory::UpdateOne($inventory->inventory_id, ['start_date' => $date]);

        $this->response(['message' => 'El inventario se actualizó con exito']);
    }

    public function show(string $id)
    {
        $inventory = Inventory::findOne($id);
        if ($this->auth()->id  !== $inventory->user_id && $this->auth()->role != User::ADMIN) return $this->response(['message' => 'El inventario no existe'], 403);

        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);
        $inventory = DependencyInventoryLocationTypeFile::Where("inventory_id = {$inventory->id}");
        $inventory->body = json_decode($inventory->body ?? "[]");
        $this->response(['inventory' => $inventory->getDataRelations($inventory)]);
    }

    public function getInventoryByUser()
    {
        $administrative_unit_id = $this->auth()->dependency_id;
        $inventory = DependencyInventoryLocationTypeFile::Where("dependency_id = $administrative_unit_id");
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

        if ($inventory->user_id !== $this->auth()->id) return $this->response(['message' => 'El inventario no existe'], 403);

        $inventory_body = DependencyInventoryLocationTypeFile::Where("inventory_id = {$inventory->id}");

        if (!$inventory_body) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);

        ['body' => $body, 'file' => $file] = $this->addNewFile($inventory_body->body, $this->request());

        $updated = $inventory_body->updateBody($inventory_body->id, $body);
        return $updated ? $this->response(['message' => 'El archivo se guardo correctamente', 'file' => $file]) :  $this->response(['message' => 'Parece que hubo un error al guardar el archivo'], 400);
    }

    public function updateFile(string $id, string $filedId)
    {
        $inventory = Inventory::findOne($id);
        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);
        if ($inventory->user_id !== $this->auth()->id) return $this->response(['message' => 'El inventario no existe'], 403);

        $inventory_body = DependencyInventoryLocationTypeFile::Where("inventory_id = {$inventory->id}");

        if (!$inventory_body) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);

        if (!$this->existFile($filedId, $inventory_body->body)) return $this->response(['message' => 'El archivo no existe o ya ha sido eliminado'], 400);

        $newBody = $this->updateCurrentFile($filedId, $inventory_body->body, $this->request());

        $inventory_body->updateBody($inventory_body->id, json_encode($newBody));

        $this->response(['message' => 'El archivo se actualizo correctamente']);
    }

    public function deleteFile(string $id, string $filedId)
    {
        $inventory = Inventory::findOne($id);
        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);
        if ($inventory->user_id !== $this->auth()->id) return $this->response(['message' => 'El inventario no existe'], 403);

        $inventory_body = DependencyInventoryLocationTypeFile::Where("inventory_id = {$inventory->id}");

        if (!$inventory_body) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);

        if (!$this->existFile($filedId, $inventory_body->body)) return $this->response(['message' => 'El archivo no existe o ya ha sido eliminado'], 400);

        $newBody = $this->removeFile($filedId, $inventory_body->body);

        $inventory_body->updateBody($inventory_body->id, json_encode($newBody));

        $this->response(['message' => 'El archivo se elimino correctamente']);
    }


    public function finalizeInventory(string $id)
    {
        $inventory = Inventory::findOne($id);
        if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);
        if ($inventory->status) return $this->response(['message' => 'El inventario ya ha sido finalizado'], 400);

        $inventoryBody = DependencyInventoryLocationTypeFile::Where("inventory_id = $inventory->id");

        if ($inventoryBody->body === null || count(json_decode($inventoryBody->body)) <= 0) return $this->response(['message' => 'El inventario no puede ser finalizado porque no ha sido llenado'], 400);
        $inventory->UpdateOne($id, ['status' => true]);
        $this->response(['message' => 'El inventario se finalizo correctamenet']);
    }

    private function addNewFile($body, $file): mixed
    {
        $newFile = [];
        if (empty($body)) {
            $body = [];
            $newFile = [...$file, 'no' => 1, 'id' => uniqid()];
            array_push($body, $newFile);
        } else {
            $body = json_decode($body);
            $newFile = [...$file, 'no' => count($body) + 1, 'id' => uniqid()];
            array_push($body, $newFile);
        }

        return ['body' => json_encode($body), 'file' => $newFile];
    }

    private function removeFile($id, $body)
    {
        $body = json_decode($body);
        $newBody = array_filter($body, fn ($file) => $file->id != $id, 1);

        return array_map(
            function ($file, $index) {
                $file->no = $index + 1;
                return $file;
            },
            $newBody,
            array_keys(array_keys($newBody))
        );
    }

    private function updateCurrentFile($id, $body, $newBody)
    {
        return array_map(function ($file) use ($id, $newBody) {
            return $file->id == $id ? [...$newBody, 'id' => $file->id, 'no' => $file->no] : $file;
        }, json_decode($body));
    }


    private function existFile(string $id, $body)
    {
        if (empty($body)) return false;
        $body = json_decode($body);
        $exist = array_filter($body, fn ($file) => $file->id == $id);
        return count($exist) == 1;
    }
}
