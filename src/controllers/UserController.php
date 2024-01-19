<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\Dependency;
use App\models\Inventory;
use App\models\User;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;
        $data = User::find($page);

        $users = array_map(function ($user) {
            $dependency = Dependency::findOne($user->dependency_id);
            $user->dependency_id = $dependency;
            return $user;
        }, $data['users']);

        $this->response(['users' => $users, 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function save()
    {
        $name = $this->post('name');
        $last_name = $this->post('last_name');
        $email = $this->post('email');
        $password = $this->post('password');
        $dependencyId = $this->post('dependency_id');
        if (!$name || !$last_name || !$email || !$password  || !$dependencyId) return $this->response(['message' => 'Los campos son obligatorios'], 400);

        if (User::findByEmail($email)) return $this->response(['message' => 'Ya existe un usuario con ese correo electronico'], 400);

        if (!Dependency::find($dependencyId)) return $this->response(['message' => 'La dependencia no esta disponible o ya ha sido asignada a otro usuario']);

        $user = new User;
        $user->save($name, $last_name, $email, $password, $dependencyId);
        $this->response(['message' => 'El usuario se creo correctamente']);
    }

    public function show(string $id)
    {
        $user = User::findOne($id);

        if (!$user) return $this->response(['message' => 'El usuario no existe'], 404);

        return $this->response(['user' => $user]);
    }

    public function update(string $id)
    {

        if (empty($this->request())) return $this->response(['message' => 'El usuario se actualizo correctamente']);

        $user = User::findOne($id);

        if (!$user) return $this->response(['message' => 'El usuario no es valido o no existe'], 400);

        $dependencyId = $this->post('dependency_id');

        $dependency = Inventory::Where("user_id = $user->id");

        if ($dependencyId != $user->dependency_id && $dependency) return $this->response(['message' => 'El usuario puede ser actualizado porque ya se han generado inventarios'], 400);

        $user->UpdateOne($id, $this->request());

        if (!$user) return $this->response(['message' =>  'Hubo un error al actualizar el usuario']);

        $this->response(['message' => 'El usuario se actualizo correctamente']);
    }

    public function delete(string $id)
    {
        $user = User::findOne($id);
        if (!$user->status)
            return $this->response(['message' => 'El usuario ya ha sido desactivado'], 400);

        $user->disableUser($id);
        $this->response(['message' => 'El usuario se desactivo correctamente'], 200);
    }

    public function active(string $id)
    {
        $user = User::findOne($id);
        if ($user->status)
            return $this->response(['message' => 'El usuario ya ha sido activado'], 400);


        $user->activeUser($id);
        $this->response(['message' => 'El usuario se activo correctamente']);
    }
}
