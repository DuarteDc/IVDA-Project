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
        return $this->response(['users' => $data['users'], 'page' => $page, 'totalPages' => $data['totalPages']]);
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

        if (!$name || !$last_name || !$email || !$password) {
            $this->setMessage(TypeAlert::Warning, 'Los campos son obligatorios');
            return header('location: /auth/users/create');
        }

        $user = User::findByEmail($email);

        if ($user) {
            $this->setMessage(TypeAlert::Danger, 'Ya existe un usuario con ese correo');
            return header('location: /auth/users/create');
        }

        $user = new User;
        $user->save($name, $last_name, $email, $password);
        $this->setMessage(TypeAlert::Success, 'El usuario se creo correctamente');
        header('location: /auth/users');
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
        if (!$user->status) {
            $this->setMessage(TypeAlert::Warning, 'El usuario ya ha sido desactivado');
            header('location: /auth/users');
        }
        $user = User::disableUser($id);
        $this->setMessage(TypeAlert::Success, 'El usuario se desactivo correctamente');
        header('location: /auth/users');
    }

    public function active(string $id)
    {
        $user = User::findOne($id);
        if ($user->status) {
            $this->setMessage(TypeAlert::Warning, 'El usuario ya ha sido activado');
            header('location: /auth/users');
        }
        $user = User::activeUser($id);
        $this->setMessage(TypeAlert::Success, 'El usuario se activo correctamente');
        header('location: /auth/users');
    }
}
