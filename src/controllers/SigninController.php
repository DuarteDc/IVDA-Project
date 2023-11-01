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

        if( !$email || !$password ) {
            $this->setMessage('El correo y contraseña son requeridos');
            return header('location: /');
        }

        $user = new User($email, $password);

        $isValidUser = $user->getUserByEmail();

        if (!$isValidUser || !$user->verifyPassword($isValidUser->password)) {
            $this->setMessage('El usuario o contraseña no son validos');
            return header('location: /');
        }

        $this::createSession($user);
        header('location: /home');
    }
}
