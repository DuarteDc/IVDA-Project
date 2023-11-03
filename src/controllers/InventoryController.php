<?php


namespace App\controllers;

use App\lib\Controller;
use App\models\Inventory;

class InventoryController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $inventories = Inventory::find();
        return $this->render('inventory/index', ['invetories' => $inventories]);
    }
}
