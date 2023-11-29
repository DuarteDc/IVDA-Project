<?php

namespace App\lib;

use App\emuns\TypeAlert;
use App\traits\AuthTrait;
class View
{

    use  AuthTrait;

    public function render(String $name, $data)
    {
        if (!empty($data)) $data = json_decode(json_encode($data));
        require __DIR__ . '/../views/' . $name . '.php';
    }
}
