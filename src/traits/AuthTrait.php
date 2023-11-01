<?php

namespace App\traits;

use App\models\User;

trait AuthTrait {

    public function auth() {
        if (isset($_SESSION['user'])) {
            return unserialize($_SESSION['user']);
        }
        return false;
    }

    public static function createSession(User $user) {
        return $_SESSION['user'] = serialize($user);
    }

}
