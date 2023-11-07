<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\User;

class UserController extends Controller {

    public function __construct() {
        parent::__construct();
    }


    public function index() {
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;
        $data = User::find($page);

        return $this->render('users/index', ['users' => $data['users'], 'page' => $page, 'totalPages' => $data['totalPages'] ]);
    }

}