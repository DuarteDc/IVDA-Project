<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\AdministrativeUnit;
use App\models\Inventory;
use App\models\SubSecretary;
use App\models\User;

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

    public function getDashboardData()
    {
        $administrative_units_count = AdministrativeUnit::countAdministrativeUnits();
        $subsecretaries_count = SubSecretary::countSubsecretaries();
        $users_count = User::countUsers();
        $inventories_count = Inventory::countInventories();
        $inventories = Inventory::find();
        

        $this->response(['administartive_units_count' => $administrative_units_count, 
            'subsecretaries_count' => $subsecretaries_count, 'users_count' => $users_count, 
            'inventories_count' => $inventories_count, 'inventories' => $inventories]);
    }
}
