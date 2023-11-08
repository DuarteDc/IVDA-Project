<?php

namespace App\lib;

use App\emuns\TypeAlert;
use App\traits\AlertTrait;
use App\traits\AuthTrait;
use App\traits\LayoutTrait;

class View
{
    
    use AlertTrait, LayoutTrait, AuthTrait;

    public function render(String $name, $data)
    {
        if (!empty($data)) $data = json_decode(json_encode($data));
        require __DIR__ . '/../views/' . $name . '.php';
    }

    public function setMessage(TypeAlert $key, string $message)
    {
        return $_SESSION[$key->value] = $message;
    }

    public function getSessionMessage()
    {
        if (isset($_SESSION[TypeAlert::Success->value])) {
            echo
            '<div class="alert alert-' . TypeAlert::Success->value . '">
                ' . $_SESSION[TypeAlert::Success->value] . '
            </div>';

            unset($_SESSION[TypeAlert::Success->value]);
        }
        if(isset($_SESSION[TypeAlert::Warning->value])) {
            echo
            '<div class="alert alert-' . TypeAlert::Warning->value . '">
                ' . $_SESSION[TypeAlert::Warning->value] . '
            </div>';
            unset($_SESSION[TypeAlert::Warning->value]);
        }
        if(isset($_SESSION[TypeAlert::Danger->value])) {
            echo
            '<div class="alert alert-' . TypeAlert::Danger->value . '">
                ' . $_SESSION[TypeAlert::Danger->value] . '
            </div>';
            unset($_SESSION[TypeAlert::Danger->value]);
        }
    }
}
