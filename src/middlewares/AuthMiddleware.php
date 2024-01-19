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

}
