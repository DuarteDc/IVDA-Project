<?php

namespace App\controllers;

use App\emuns\TypeAlert;
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

        return $this->response(['inventories' => $data['inventories'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }   

    public function create()
    {
        $currentDate = date("Y-m-d H:i:s");
        $name = 'Inventario del' . $currentDate;
        $inventory = new Inventory();

        $newInventory = $inventory->save($name, $currentDate, $this::auth()->id);
        if (!$newInventory) {
            $this->setMessage(TypeAlert::Danger, 'Parece que hubo un error al crear el inventario');
            return header('location: /auth/inventory');
        }

        $this->setMessage(TypeAlert::Success, 'El inventario se creo con exito');
        return header('location: /auth/inventory/edit/' . $newInventory->id);
    }


    public function edit(string $id)
    {
        $inventory = Inventory::findOne($id);
        if (!$inventory)
            return $this->render('404/index');

        $this->render('inventory/edit', ['inventory' => $inventory]);
    }
}
