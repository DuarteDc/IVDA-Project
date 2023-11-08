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
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;
        $data = Inventory::find($page);
        return $this->render('inventory/index', ['invetories' => $data['inventories'], 'page' => $page, 'totalPages' => $data['totalPages'] ]);
    }
}
