<?php

namespace App\middlewares;

use App\lib\Middleware;
use App\models\User;

class HasAdminRole extends Middleware {

    public static function hasAdminRole () {        
        if (static::auth()->role != User::ADMIN) 
            return static::response(['message' => '403 - Forbidden'], 403);
    }

}