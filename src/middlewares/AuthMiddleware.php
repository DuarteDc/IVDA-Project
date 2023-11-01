<?php

namespace App\middlewares;

use App\lib\Middleware;

class AuthMiddleware extends Middleware {

    public function checkAuth() {
        if( gettype($this->auth())  == 'boolean') {
            header("HTTP/1.1 307 Temporary Redirect");
            return header('location: /');    
        }
    }

    public function isAuthenticate () {
        if( gettype($this->auth()) != 'boolean') {
            header("HTTP/1.1 307 Temporary Redirect");
            return header('location: /auth');    
        }
    }


}