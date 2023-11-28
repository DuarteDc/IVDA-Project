<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\AdministrativeUnitInventorySubsecretary;
use App\models\Inventory;
use DOMDocument;

class ReportController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function generateReport(string $id)
    {
        try {
            $inventory = Inventory::findOne($id);
            if (!$inventory) return $this->response(['message' => 'El inventario no existe o no esta disponible'], 400);
            if ($this->auth()->id !== $inventory->user_id) return $this->response(['message' => 'No se puede generar el reporte porque no eres el creador del inventario'], 403);

            if (!$inventory->status) return $this->response(['message' => 'El inventario no ha sido finalizado para poder generar el reporte'], 403);

            $inventory = AdministrativeUnitInventorySubsecretary::Where("inventory_id = $inventory->id");
            $inventory = $inventory->getDataRelations($inventory);
            $inventory->body = json_decode($inventory->body ?? "[]");

            ob_start();
            $this->render('report/index', ['inventory' => $inventory]);
            $document = ob_get_clean();

            
            
        } catch (\Throwable $th) {
            $this->response(['message' => $th->getMessage()]);
        }
    }
}
