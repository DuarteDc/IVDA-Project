<?php

namespace App\controllers;

use App\emuns\TypeAlert;
use App\lib\Controller;
use App\models\AdministrativeUnit;
use App\models\AdministrativeUnitInventorySubsecretary;
use App\models\SubSecretary;

class AdministrativeUnitController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;

        $data = AdministrativeUnit::find($page);

        $this->response(['administrative_units' => $data['administrative_units'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function show(string $id)
    {
        $administrative_unit = AdministrativeUnit::findOne($id);
        if (!$administrative_unit) $this->response(['message' => 'La unidad administrativa que intentas buscar no existe'], 400);
        $this->response(['administrative_unit' => $administrative_unit]);
    }

    public function save()
    {
        $name = $this->post('name');
        $subsecretary = $this->post('subsecretary_id');

        if (!$name || !$subsecretary) return $this->response(['message' => 'Los campos son requeridos para crear una unidad administrativa'], 400);

        $existSubsecretary = SubSecretary::findOne($subsecretary);

        if (!$existSubsecretary) return $this->response(['message' =>  'La subsecretaria no es correcta o no esta disponible'], 400);

        $administrative = new AdministrativeUnit();
        $administrative->save($name, $subsecretary);

        $this->response(['message' => 'La unidad administrativa se creo con exito']);
    }

    public function getBySubsecretary(string $subsecretary_id)
    {
        $administrative_units = AdministrativeUnit::findBySubsecretary($subsecretary_id);

        $this->response(['administrative_units' => $administrative_units]);
    }

    public function delete(string $id)
    {
        $administrative_unit = AdministrativeUnit::findOne($id);

        if (!$administrative_unit) return $this->response(['message' => 'La unidad administrativa no existe o no es valida'], 404);

        if (!$administrative_unit->status) return $this->response(['message' => 'La unidad administratuva ya ha sido desactivada'], 400);

        $users = $administrative_unit->users($administrative_unit);

        if (count($users) > 0) return $this->response(['message' => 'La unidad administrativa no puede ser eliminada porque cuenta con usuarios activos'], 400);

        $inventory = AdministrativeUnitInventorySubsecretary::Where("administrative_unit_id = $administrative_unit->id");
        if($inventory) return $this->response(['message' => 'La unidad administrativa no se puede desactivar porque ya existe inventarios creados con esa unidad administrativa'], 400);

        $administrative_unit->changeStatus($administrative_unit->id, false);
        $this->response(['message' => 'La unidad administrativa se desactivo correctamente']);
    }


    public function active(string $id)
    {
        $administrative_unit = AdministrativeUnit::findOne($id);

        if (!$administrative_unit) return $this->response(['message' => 'La unidad administrativa no existe o no es valida'], 404);

        if ($administrative_unit->status) return $this->response(['message' => 'La unidad administrativa ya ha sido activada'], 400);

        $administrative_unit->changeStatus($administrative_unit->id, true);
        $this->response(['message' => 'La unidad administrativa se desactivo correctamente']);
    }

    public function update(string $id)
    {
        $administrative_unit = AdministrativeUnit::findOne($id);
        if (!$administrative_unit) return $this->response(['message' => 'La subsecretaría no existe o no es valida'], 400);

        $name = $this->post('name');
        $subsecretary_id = $this->post('name');

        if ($subsecretary_id != $administrative_unit->subsecretary_id) {
            $inventory = AdministrativeUnitInventorySubsecretary::Where("administrative_unit_id = $administrative_unit->id");
            if ($inventory) return $this->response(['message' => 'La unidad administrativa no se puede actualizar porque ya existe inventarios creados con esa unidad administrativa'], 400);
        }

        $name = trim(strtoupper($name));

        $subsecretary = SubSecretary::Where("id <> {$id} AND name = {$name}");

        if ($subsecretary) return $this->response(['message' => 'Ya existe una subsecretaria con ese nombre'], 400);

        $administrative_unit->UpdateOne($id, $this->request());
        $this->response(['message' => 'La subsecretaria se actualizo con exito']);
    }
}
