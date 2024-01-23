<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\AdministrativeUnit;
use App\models\Dependency;
use App\models\DependencyInventoryLocationTypeFile;
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
        $users_count = User::countUsers();
        $inventories_count = Inventory::countInventories();
        $inventories = Inventory::findLastInventories();
        $dependencies = Dependency::countDependencies();

        array_map(function ($inventory) {
            $inventory->dependency_id = Dependency::findOne(DependencyInventoryLocationTypeFile::Where("inventory_id = $inventory->id")->dependency_id);
        }, $inventories);

        $this->response([
            'users_count' => $users_count,
            'inventories_count' => $inventories_count,
            'inventories' => $inventories,
            'dependencies' => $dependencies,
        ]);
    }
}
