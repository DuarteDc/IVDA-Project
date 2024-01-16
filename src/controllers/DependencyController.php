<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\Dependency;
use App\models\DependencyInventory;
use App\models\SubSecretary;

class DependencyController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;

        $data = Dependency::find($page);

        $this->response(['dependencies' => $data['dependencies'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function show(string $id)
    {
        $dependency = Dependency::findOne($id);
        if (!$dependency) $this->response(['message' => 'La unidad dependencia que intentas buscar no existe'], 400);
        $this->response(['dependency' => $dependency]);
    }

    public function save()
    {
        $name = $this->post('name');
        $code = trim(mb_strtoupper($this->post('code')));

        if (!$name || !$code) return $this->response(['message' => 'Los campos son requeridos para crear una unidad administrativa'], 400);

        $dependency = Dependency::where("code = '$code'");

        if ($dependency) return $this->response(['message' => 'Actualmente ya existe una dependencia con ese código estructural'], 400);

        $name = trim(ucwords($name));

        $dependency = Dependency::where("name = '$name'");
        if ($dependency) return $this->response(['message' => 'Ya existe una dependencía con ese nombre'], 400);

        $dependency = new Dependency();
        $dependency->save($name, $code);

        $this->response(['message' => 'La dependencia se creo con exito']);
    }

    public function getByUser()
    {
        $dependencyId = $this->auth()->dependency_id;
        
        $dependency = Dependency::findOne($dependencyId);

        $this->response(['dependency' => $dependency]);
    } 

    public function delete(string $id)
    {
        $dependency = Dependency::findOne($id);

        if (!$dependency) return $this->response(['message' => 'La dependencia no existe o no es valida'], 404);

        if (!$dependency->status) return $this->response(['message' => 'La dependencia ya ha sido desactivada'], 400);

        // $users = $dependency->users($dependency);

        // if (count($users) > 0) return $this->response(['message' => 'La unidad administrativa no puede ser eliminada porque cuenta con usuarios activos'], 400);

        // $inventory = DependencyInventory::Where("dependency_id = $dependency->id");

        // if ($inventory) return $this->response(['message' => 'La unidad administrativa no se puede desactivar porque ya existe inventarios creados con esa unidad administrativa'], 400);

        $dependency->changeStatus($dependency->id, false);
        $this->response(['message' => 'La dependencia se desactivo correctamente']);
    }


    public function active(string $id)
    {
        $dependency = Dependency::findOne($id);

        if (!$dependency) return $this->response(['message' => 'La dependencia no existe o no es valida'], 404);

        if ($dependency->status) return $this->response(['message' => 'La dependencia ya ha sido activada'], 400);

        $dependency->changeStatus($dependency->id, true);
        $this->response(['message' => 'La dependencia se desactivo correctamente']);
    }

    public function update(string $id)
    {
        $name = $this->post('name');
        $code = trim(mb_strtoupper($this->post('code')));
        $dependency = Dependency::where("code = '$code' AND id <> '$id'");

        if ($dependency) return $this->response(['message' => 'El código estructural ya existe en otra dependencia'], 400);

        $name = trim(ucwords($name));

        $dependency = Dependency::where("name = '$name' AND id <> $id");
        if ($dependency) return $this->response(['message' => 'Ya existe una dependencia con ese nombre']);

        $dependency = Dependency::findOne($id);
        if (!$dependency) return $this->response(['message' => 'La dependencia no existe o no es valida'], 400);

        $dependency->UpdateOne($id, ['name' => $name, 'code' => $code]);
        $this->response(['message' => 'La dependencia se actualizo con exito']);
    }
}
