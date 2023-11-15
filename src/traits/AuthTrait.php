<?php

namespace App\traits;

use App\models\User;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait AuthTrait
{

    public static function auth()
    {
        $session = $_SERVER['HTTP_SESSION'] ?? '';
        $key = $_ENV['JWT_SECRET_KEY'];
        $decode = JWT::decode($session, new Key($key, 'HS256'));
        return $decode->user;
    }

    public static function createSession(User $user)
    {
        return $_SESSION['user'] = serialize($user);
    }


    public static function generateJWT($payload)
    {
        JWT::$leeway = 60;
        $key = $_ENV['JWT_SECRET_KEY'];
        $data = [
            'iat' => 1356999524,
            'user' => $payload,
        ];
        $token = JWT::encode($data, $key, 'HS256');
        return ['user' => $payload, 'session' => $token];
    }

    public static function isValidToken($token)
    {
        $key = $_ENV['JWT_SECRET_KEY'];
        $decode = JWT::decode($token, new Key($key, 'HS256'));
        return self::generateJWT($decode->user);
    }
}
