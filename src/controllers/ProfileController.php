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

        $currentUser = $this->auth();

        if ($this->post('email')) {
            $user = User::findByEmail($this->post('email'));
            if ($user && $user->id !== $this::auth()->id) {
                $this->setMessage(TypeAlert::Warning, "Ya existe un usuario con el correo {$this->post('email')}");
                return header('location: /auth/profile');
            }
        }

        $user = User::UpdateOne($currentUser->id, $_POST);

        if (!$user) {
            $this->setMessage(TypeAlert::Danger, 'Hubo un error al actualizar la información');
            return header('location: /auth/profile');
        }
        $this::createSession($user);
        $this->setMessage(TypeAlert::Success, 'El perfil se actualizo correctamente');
        header('location: /auth/profile');
    }
}
