<?php

namespace App\controllers;

use App\emuns\OrientationTypes;
use App\emuns\PaperTypes;
use App\lib\Controller;
use App\models\DependencyInventoryLocationTypeFile;
use App\models\Inventory;
use App\models\User;

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

            if ($this->auth()->role != User::ADMIN && $this->auth()->id !== $inventory->user_id) return $this->response(['message' => 'No se puede generar el reporte porque no eres el creador del inventario'], 403);

            if (!$inventory->status) return $this->response(['message' => 'El inventario no ha sido finalizado para poder generar el reporte'], 403);

            $inventory = DependencyInventoryLocationTypeFile::Where("inventory_id = $inventory->id");
            $inventory = $inventory->getDataRelations($inventory);
            $inventory->body = json_decode($inventory->body ?? "[]");

            $fistImage = base64_encode(file_get_contents(__DIR__ . "/../../public/img/escudo.png"));
            $secondImage = base64_encode(file_get_contents(__DIR__ . "/../../public/img/edomex.png"));

            ob_start();

            $admin = User::where("role = 0");
            $userId = $inventory->inventory_id->user_id;
            $user = User::where("id = $userId");

            $this->render('report/index', ['inventory' => $inventory, 'fisrtImage' => $fistImage, 'secondImage' => $secondImage, 'admin' => $admin, 'user' => $user]);
            $document = ob_get_clean();


            header("Access-Control-Allow-Origin: *");
            http_response_code(200);

            $this->generatePDF($document, PaperTypes::A4, OrientationTypes::Landscape, "Inventario general de archivo");
        } catch (\Throwable $th) {
            $this->response(['message' => $th->getMessage()]);
        }
    }
}
