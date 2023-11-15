<?php

namespace App\middlewares;

use App\lib\Middleware;

class AuthMiddleware extends Middleware {

    public static function checkAuth() {
        $session = $_SERVER['HTTP_SESSION'] ?? '';
        if (!$session) return self::response(['message' => "unauthorized - 401"], 401);
    }

    public static function isAuthenticate () {
        if( gettype(self::auth()) != 'boolean') {
            header("HTTP/1.1 307 Temporary Redirect");
            return header('location: /auth');    
        }
    }


}