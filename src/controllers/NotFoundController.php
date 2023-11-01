<?php

namespace App\controllers;

use App\lib\Controller;

class NotFoundController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function __invoke()
    {
        header('HTTP/1.1 404 Not Found');
        return $this->render('404/index');
    }
}
