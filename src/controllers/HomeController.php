<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $users = User::findAll();
        return $this->render('home/index', ['userCount' => $users]);
    }
}
