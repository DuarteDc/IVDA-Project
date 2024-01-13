<?php

namespace App\traits;

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
            return self::generateJWT($decode->user);
        } catch (Exception $e) {
            return new Exception($e->getMessage());
        }
    }
}
