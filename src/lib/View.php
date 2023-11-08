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
            echo'
            <div class="alert max-w-md w-full bg-gradient-to-r from-green-600 from-15% via-zinc-800 to-zinc-900 to-80% shadow-lg rounded-lg font-bold pointer-events-auto flex text-white py-3 px-6 absolute z-50 top-5 lg:top-10 right-0 lg:right-10">
                <div class="flex items-center w-full relative">
                    <div>
                        <span class="block text-lg">Correcto</span>
                        <span class="block text-sm">'.$_SESSION[TypeAlert::Success->value].'</span>
                    </div>
                </div>
            </div>
            ';
            unset($_SESSION[TypeAlert::Success->value]);
        }

        if (isset($_SESSION[TypeAlert::Warning->value])) {
            echo
            '<div class="alert max-w-md w-full bg-gradient-to-r from-orange-600 from-15% via-zinc-800 to-zinc-900 to-80% shadow-lg rounded-lg font-bold pointer-events-auto flex text-white py-3 px-6 absolute z-50 top-5 lg:top-10 right-0 lg:right-10">
                <div class="flex items-center w-full relative">
                    <div>
                        <span class="block text-lg">Opps</span>
                        <span class="block text-sm">'.$_SESSION[TypeAlert::Warning->value].'</span>
                    </div>
                </div>
            </div>';
            unset($_SESSION[TypeAlert::Warning->value]);
        }
        if (isset($_SESSION[TypeAlert::Danger->value])) {
            echo'
            <div class="alert max-w-md w-full bg-gradient-to-r from-red-600 from-15% via-zinc-800 to-zinc-900 to-80% shadow-lg rounded-lg font-bold pointer-events-auto flex text-white py-3 px-6 absolute z-50 top-5 lg:top-10 right-0 lg:right-10">
                <div class="flex items-center w-full relative">
                    <div>
                        <span class="block text-lg">Opps</span>
                        <span class="block text-sm">'.$_SESSION[TypeAlert::Danger->value].'</span>
                    </div>
                </div>
            </div>
            ';
            unset($_SESSION[TypeAlert::Danger->value]);
        }
    }
}
