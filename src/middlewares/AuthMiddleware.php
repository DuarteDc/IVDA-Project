<?php

namespace App\middlewares;

use App\lib\Middleware;

class AuthMiddleware extends Middleware {

    public static function checkAuth() {
        if( gettype(self::auth())  == 'boolean') {
            header("HTTP/1.1 307 Temporary Redirect");
            return header('location: /');    
        }
    }

    public static function isAuthenticate () {
        if( gettype(self::auth()) != 'boolean') {
            header("HTTP/1.1 307 Temporary Redirect");
            return header('location: /auth');    
        }
    }


}