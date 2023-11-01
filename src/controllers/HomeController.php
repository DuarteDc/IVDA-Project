<?php

namespace App\controllers;

use App\lib\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->render('home/index');
    }
}
