<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\User;

class SigninController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->render('signin/index');
    }

    public function signin()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        if (!$email || !$password) {
            $this->setMessage('El correo y contraseña son requeridos');
            return header('location: /');
        }

        $user = User::findByEmail($email);

        if (!$user || !$user->verifyPassword($password, $user->password)) {
            $this->setMessage('El usuario o contraseña no son validos');
            return header('location: /');
        }

        $this::createSession($user);
        header('location: /auth');
    }
}
