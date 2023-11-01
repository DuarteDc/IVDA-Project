<?php

namespace App\traits;


trait AlertTrait
{

    function showAlert(string $key)
    {
        if (empty($_SESSION[$key])) return;
        echo
        "<div class='alert bg-gradient-to-r from-red-600 from-15% via-slate-800 to-slate-800 to-80% shadow-lg rounded-lg font-bold pointer-events-auto flex items-center text-white py-3 px-4 z-40 absolute top-5'>
            {$this->errorIcon()}
            {$_SESSION[$key]}
        </div>";
        unset($_SESSION[$key]);
    }


    private function errorIcon()
    {
        return
        '<span class="p-1 bg-red-500 rounded-lg text-red-100 mr-2 font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor" fill="none" strokeLinecap="round" strokeLinejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M18 6l-12 12"></path>
                <path d="M6 6l12 12"></path>
            </svg>
        </span>';
    }
}
