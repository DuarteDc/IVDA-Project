<?php

namespace App\traits;

use App\models\User;
use Exception;
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

    public static function generateJWT($payload)
    {
        $key = $_ENV['JWT_SECRET_KEY'];

        unset($payload->password);

        $data = [
            'exp' => strtotime('now') + 3600,
            'user' => $payload,
        ];
        $token = JWT::encode($data, $key, 'HS256');
        return ['user' => $payload, 'session' => $token];
    }

    public static function isValidToken(string $token)
    {
        try {
            $key = $_ENV['JWT_SECRET_KEY'];
            $decode = JWT::decode($token, new Key($key, 'HS256'));

            $user = User::findOne($decode->user->id);

            if(!$user || !$user->status) return new Exception("401 - Unauthorized");

            return self::generateJWT($user);
        } catch (Exception $e) {
            return new Exception($e->getMessage());
        }
    }
}
