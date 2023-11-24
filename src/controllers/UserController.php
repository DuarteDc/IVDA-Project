<?php

namespace App\controllers;

use App\emuns\TypeAlert;
use App\lib\Controller;
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
        $this->response(['users' => $data['users'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function save()
    {

        $name = $this->post('name');
        $last_name = $this->post('last_name');
        $email = $this->post('email');
        $password = $this->post('password');
        $role = $this->post('role');
        $administrative_unit_id = $this->post('administrative_unit_id');

        if (!$name || !$last_name || !$email || !$password  || !isset($role)) {
            return $this->response(['message' => 'Los campos son obligatorios'], 400);
        }

        if ($role == "0" && empty($administrative_unit_id))
            return $this->response(['message' => 'La unidad administrativa es obligatorio para crear un usuario'], 400);


        $user = User::findByEmail($email);

        if ($user) {
            return $this->response(['message' => 'Ya existe un usuario con ese correo electronico'], 400);
        }

        $user = new User;
        $user->save($name, $last_name, $email, $password, (int) $role, $administrative_unit_id);
        $this->response(['message' => 'El usuario se creo correctamente']);
    }

    public function show(string $id)
    {
        $user = User::findOne($id);

        if (!$user)
            return $this->response(['message' => 'El usuario no existe'], 404);

        return $this->response(['user' => $user]);
    }

    public function update(string $id)
    {
        if (empty($this->request())) return $this->response(['message' => 'El usuario se actualizo correctamente']);

        $user = User::findOne($id);

        if (!$user) return $this->response(['message' => 'El usuario no es valido o no existe'], 400);

        if($this->post('role') == '0' && empty($this->post('administrative_unit_id'))) return $this->response(['message' => 'Es necesario asignarle una unidad administrativa al usuario'], 400);

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
