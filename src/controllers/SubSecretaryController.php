<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\SubSecretary;

class SubSecretaryController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;
        $data = SubSecretary::find($page);
        $this->response(['subsecretaries' => $data['subsecretaries'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function save()
    {
        $name = $this->post('name');

        if (!$name) return $this->response(['message' => 'El nombre es requerido para crear una subsecretaria'], 400);

        $name = trim(mb_strtoupper($name));

        $existSubsecretary = SubSecretary::Where("name = '$name'");

        if ($existSubsecretary) return $this->response(['message' => 'Ya existe una subsecretaria con ese nombre'], 400);

        $subsecretary = new SubSecretary();
        $subsecretary->save($name);

        $this->response(['message' => 'La subsecretaria se creo con exito']);
    }

    public function show(string $id)
    {
        $subsecretary = SubSecretary::findOne($id);

        if (!$subsecretary) return $this->response(['message' => 'La subsecretaria que intentas buscar no existe'], 400);

        $administrative_units = $subsecretary->administrativeUnits($subsecretary);

        $administrative_units = array_map(function ($administrative_unit) use ($subsecretary) {
            $administrative_unit->subsecretary_id = $subsecretary->name;
            return $administrative_unit;
        }, $administrative_units);

        $this->response([
            'subsecretary' => $subsecretary, 'administrative_units' => $administrative_units,
            'inventories' => $subsecretary->inventories($subsecretary, false), 'users' => $subsecretary->users($subsecretary)
        ]);
    }

    public function update(string $id)
    {
        $subsecretary = SubSecretary::findOne($id);
        if (!$subsecretary) return $this->response(['message' => 'La subsecretaría no existe o no es valida']);

        $name = $this->post('name');

        $name = trim(mb_strtoupper($name));

        $existSubsecretary = SubSecretary::Where("id <> {$id} AND name = '{$name}'");
        if ($existSubsecretary) return $this->response(['message' => 'Ya existe una subsecretaria con ese nombre'], 400);

        $subsecretary->UpdateOne($id, ['name' => $name]);
        $this->response(['message' => 'La subsecretaria se actualizo con exito']);
    }

    public function getAll()
    {
        $subsecretaries = SubSecretary::WhereStatus(true);
        $this->response(['subsecretaries' => $subsecretaries]);
    }


    public function delete(string $id)
    {
        $subsecretary = SubSecretary::findOne($id);

        if (!$subsecretary) return $this->response(['message' => 'Parece que la subsecretaria no existe o no esta disponible'], 400);

        if (!$subsecretary->status) return $this->response(['message' => 'La subsecretaria ya ha sido desactivada'], 400);

        $administrative_units = $subsecretary->administrativeUnits($subsecretary, true);

        if (count($administrative_units) > 0) return $this->response(['message' => 'La subsecretaria no puede ser desactivada porque cuenta con unidades administrativas activas'], 400);

        $subsecretary->disableSubsecretary($subsecretary->id);

        $this->response(['message' => 'La subsecretaria se desactivo correctamente']);
    }

    public function active(string $id)
    {
        $subsecretary = SubSecretary::findOne($id);

        if (!$subsecretary) return $this->response(['message' => 'Parece que la subsecretaria no existe o no esta disponible'], 400);

        if ($subsecretary->status) return $this->response(['message' => 'La subsecretaria ya ha sido activada'], 400);

        $subsecretary->activeSubsecretary($subsecretary->id);

        $this->response(['message' => 'La subsecretaria se activo correctamente']);
    }
}
