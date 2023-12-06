<?php

namespace App\middlewares;

use App\lib\Middleware;
use Exception;

class AuthMiddleware extends Middleware
{

    public static function checkAuth()
    {
        $session = $_SERVER['HTTP_SESSION'] ?? '';
        if (!$session) return self::response(['message' => "Unauthorized - 401"], 401);
        $session = self::isValidToken($session);
        if ($session instanceof Exception) return self::response(['message' => $session->getMessage()], 401);
    }

    public static function isAuthenticate()
    {
        if (gettype(self::auth()) != 'boolean') {
            header("HTTP/1.1 307 Temporary Redirect");
            return header('location: /auth');
        }
    }
}
