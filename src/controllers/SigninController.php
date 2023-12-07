<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\User;
use Exception;

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

        if (!$email || !$password)
            return $this->response(['message' => 'El usuario y contraseña son requeridos'], 400);

        $user = User::findByEmail($email);

        if (!$user || !$user->verifyPassword($password, $user->password) || !$user->status)
            return $this->response(['message' => 'El usuario o contraseña no son validos'], 400);

        $response = $this::generateJWT($user);
        return $this->response($response);
    }

    public function user()
    {
        $session = $_SERVER['HTTP_SESSION'] ?? '';
        if (!$session) return $this->response(['message' => "unauthorized - 401"], 401);
        $session = $this::isValidToken($session);
        if ($session instanceof Exception) return $this->response(['message' => $session->getMessage()], 401);
        $this->response($session);
    }

    public function send() {
        $this->response($this->sendMail('duartedc17@gmail.com', 'Prueba', 'duartedc17@gmail.com', 'Eduardo Duarte', 'text/html", "<strong>and easy to do anywhere, even with PHP</strong>'));
    }
}
