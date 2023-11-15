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

        if (!$email || !$password)
            return $this->response(['message' => 'El usuario y contraseña son requeridos'], 400);


        $user = User::findByEmail($email);

        if (!$user || !$user->verifyPassword($password, $user->password))
            return $this->response(['message' => 'El usuario o contraseña no son validos'], 400);


        $response = $this::generateJWT($user);
        return $this->response($response);
    }

    public function user()
    {
        $session = $_SERVER['HTTP_SESSION'] ?? '';
        if (!$session) return $this->response(['message' => "unauthorized - 401"], 401);
        $xd = $this::isValidToken($session);
        $this->response($xd);
    }
}
