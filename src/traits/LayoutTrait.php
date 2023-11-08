<?php

namespace App\traits;

use Bramus\Router\Router;

trait LayoutTrait
{

    private Router $router;

    public function section(string $title = 'title', string $styles = '') 
    {
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>' . $title . '</title>
                <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
                <link href='.$styles.' rel="stylesheet">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.11.0/css/flag-icons.min.css"/>
                <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
            </head> 
            <body>
        ';
    }

    public function endSection()
    {
        echo '
        </body>
        </html>';
    }

    public function scripts(string $src)
    {
        echo '
            <script src=' . $src . 'type="module"></script>
            <script src="https://kit.fontawesome.com/e9125d43dc.js" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
        ';
    }

    public function authLayout()
    {
        $this->router = new Router();

        $currentUri = $this->router->getCurrentUri();
        echo '
            <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <img src="https://ui-avatars.com/api/?name='.$this->auth()->name . $this->auth()->last_name.'" alt='.$this->auth()->name.'" loading="lazy" class="img-profile" width="50" heigth="50">
                </ul>
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link">
                <span class="brand-text">Inicio</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item menu-open">
                    <a href="/" class="nav-link py-4 px-4' . ($currentUri === '/auth' ? " active" : "")  . '">
                    <i class="fa-solid fa-house"></i>
                        <p>
                        Inicio
                        </p>
                    </a>
                    </li>
                    <li class="nav-item menu-open">
                    <a href="/auth/inventory" class="nav-link py-4 px-4' . (str_contains($currentUri, '/auth/inventory') ? " active" : "")  . '">
                        <i class="fa-solid fa-file"></i>
                        <p>
                        Inventario
                        </p>
                    </a>
                    </li>
                    <li class="nav-item menu-open">
                    <a href="/auth/users" class="nav-link py-4 px-4' . (str_contains($currentUri, '/auth/users') ? " active" : "")  . '">
                        <i class="fa-solid fa-users"></i>
                        <p>
                        Usuarios
                        </p>
                    </a>
                    </li>
                </ul>
                </nav>
            </div>
            </aside>
            <main class="wrapper content-wrapper px-md-5 px-2">
            ';
    }

    public function endAuthLayout()
    {
        echo '</main>';
    }
}
