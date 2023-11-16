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


    public function create()
    {
        return $this->render('users/create');
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
        
        if ($role == "0" && !isset($administrative_unit_id)) {
            return $this->response(['message' => 'La unidad administrativa es obligatorio para un usario'], 400);
        }

        $user = User::findByEmail($email);

        if ($user) {
            return $this->response(['message' => 'Ya existe un usuario con ese correo electronico'], 400);
        }

        $user = new User;
        $user->save($name, $last_name, $email, $password, (int) $role, $administrative_unit_id);
        $this->response(['message' => 'El usuario se creo correctamente']);

    }

    public function edit(string $id)
    {
        $user = User::findOne($id);

        if (!$user) {
            header('HTTP/1.1 404 Not Found');
            return $this->render('404/index');
        }

        return $this->render('users/edit', ['user' => $user]);
    }

    public function update(string $id)
    {
        $user = User::UpdateOne($id, $_POST);
        if (!$user) {
            $this->setMessage(TypeAlert::Warning, 'Hubo un error al actualizar el usuario');
            return header('location: /auth/users');
        }

        $this->setMessage(TypeAlert::Success, 'El usuario se actualizo correctamente');
        header('location: /auth/users');
    }

    public function delete(string $id)
    {
        $user = User::findOne($id);        
        if (!$user->status) 
            return $this->response(['message' => 'El usuario ya ha sido desactivado'], 400);
        
        $user = User::disableUser($id);
        $this->response(['message' => 'El usuario se desactivo correctamente'], 200);
    }

    public function active(string $id)
    {
        $user = User::findOne($id);
        if ($user->status) 
            return $this->response(['message' => 'El usuario ya ha sido activado'], 400);
            
        
        $user = User::activeUser($id);
        $this->response(['message' => 'El usuario se activo correctamente']);
    }
}
