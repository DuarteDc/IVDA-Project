<?php

namespace App\middlewares;

use App\lib\Middleware;

class HasAdminRole extends Middleware {

    public static function hasUserRole () {
        $user = self::auth();
        
        if ($user->role == 0) {
            header("HTTP/1.1 307 Temporary Redirect");
            return header('location: /user');    
        }
    }


    public static function hasAdminRole () {
        $user = self::auth();
        
        if ($user->role == 1) {
            header("HTTP/1.1 307 Temporary Redirect");
            return header('location: /auth');    
        }
    }

}