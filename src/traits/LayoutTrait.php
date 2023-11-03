<?php

namespace App\traits;

trait LayoutTrait
{
    public function section(String $title= 'title')
    {
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>' . $title . '</title>
                <script src="https://cdn.tailwindcss.com"></script>
                <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
                <link href="./../css/styles.css" rel="stylesheet">
            </head> 
            <body class="bg-gray-100">
        ';
    }

    public function endSection()
    {
        echo '
        </body>
        </html>';
    }

    public function scripts(String $src)
    {
        echo '
            <script src=' . $src . 'type="module" defer></script>
        ';
    }

    public function authLayout() {
        echo '
        <main class="flex transition-all duration-500 ease-in static">
        <aside class="lg:w-[400px] md:w-[200px] w-[100px] bg-blue-700 min-h-screen text-center text-white transition-all duration-500 ease-in left-0 rounded-r-xl">
        <div class="border-b-2 w-full py-7">
        Home
        </div>
        <ul class="[&>li]:py-6 [&>li]:transition-all [&>li]:duration-500 [&>li]:ease-in font-bold lg:px-5 px-2 py-4 [&>li]:rounded-3xl [&>li]:my-4 [&>li]:flex [&>li]:items-center [&>li]:justify-center [&>li]:lg:px-4 [&>li]:lg:justify-start">
        <li class="hover:bg-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
            <path d="M10 12h4v4h-4z"></path>
            </svg>
            <span class="hidden md:block mx-2">Inicio</span>
        </li>
        <li class="hover:bg-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
            <path d="M9 9l1 0"></path>
            <path d="M9 13l6 0"></path>
            <path d="M9 17l6 0"></path>
            </svg>
            <span class="hidden md:block mx-2">Reportes</span>
        </li>
        <li class="hover:bg-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
            </svg>
            <span class="hidden md:block mx-2">Usuarios</span>
        </li>
        </ul>
    </aside>
    <section class="w-full transition-all duration-500 ease-in">
        <nav class="w-full top-0 py-4 font-bold px-5 flex justify-between items-center max-w-screen overflow-hidden text-black transition-all duration-500 ease-in" aria-toggle="true">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2 cursor-pointer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M4 6l16 0"></path>
            <path d="M4 12l16 0"></path>
            <path d="M4 18l16 0"></path>
            </svg>
        </span>
        <div class="flex items-center">
            <div class="rounded-full overflow-hidden w-12 h-12 ml-4">
            <img src="https://ui-avatars.com/api/?name='.$this->auth()->name . $this->auth()->last_name.'" alt="user" loading="lazy">
            </div>
        </div>
        </nav>';
    }

    public function endAuthLayout() {
        echo '</main>';

    }

}
