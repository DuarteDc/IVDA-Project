<?php

namespace App\lib;

use App\emuns\TypeAlert;
use App\traits\AlertTrait;
use App\traits\AuthTrait;
use App\traits\LayoutTrait;
use App\traits\QueryParamsTrait;

class View
{

    use AlertTrait, LayoutTrait, AuthTrait, QueryParamsTrait;

    public function render(String $name, $data)
    {
        if (!empty($data)) $data = json_decode(json_encode($data));
        require __DIR__ . '/../views/' . $name . '.php';
    }

    public function view($name, $data)
    {
        if (!empty($data)) $data = json_decode(json_encode($data));
         return __DIR__ . '/../views/' . $name . '.php';
    }

    public function setMessage(TypeAlert $key, string $message)
    {
        return $_SESSION[$key->value] = $message;
    }
}
