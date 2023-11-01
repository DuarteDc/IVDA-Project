<?php

namespace App\lib;

use App\traits\AlertTrait;
use App\traits\LayoutTrait;

class View
{
    use AlertTrait, LayoutTrait;

    public function render(String $name, $data = [])
    {
        require __DIR__ . '/../views/' . $name . '.php';
    }

    public function setMessage(String $message) {
        return $_SESSION['message'] = $message;
    }

    public function getSessionMessage(String $key) {
        return $_SESSION[$key];
    }
}
