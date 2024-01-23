<?php

namespace App\controllers;

use App\emuns\TypeAlert;
use App\lib\Controller;
use App\models\User;

class ProfileController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('profile/index');
    }

    public function update()
    {

        if ($this->auth()->role != User::ADMIN) return $this->response(['message' => 'El usuario no puede ser actualizado'], 403);
        $email = $this->post('email');
        $user = User::where("email = $email AND id <> {$this->auth()->id}");

        if ($user) return $this->response(['message' => 'Hay existe un usuario con ese correo electronico'], 400);

        $user = User::UpdateOne($this->auth()->id, $this->request());

        unset($user->password);

        return $user ? $this->response(['message' => 'El perfil se actualizo correctamente', 'user' => $user]) : $this->response(['message' => 'Parece que hubo un error al actualizar el perfil']);
    }
}
