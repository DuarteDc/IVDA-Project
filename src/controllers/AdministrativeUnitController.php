<?php

namespace App\controllers;

use App\emuns\TypeAlert;
use App\lib\Controller;
use App\models\AdministrativeUnit;
use App\models\SubSecretary;

class AdministrativeUnitController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $page = (int) $this->get('page');
        $page == 0 && $page = 1;

        $type = $this->get('type');
        !$type || $type == 'true' || $type != 'false' ? $type = true : $type = false;

        $data = AdministrativeUnit::find($page, $type);
        
        $this->render('administrative-unit/index', ['administrative_units' => $data['administrative_units'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function create()
    {
        $subsecretaries = SubSecretary::findAll();
        $this->render('administrative-unit/create', ['subsecretaries' => $subsecretaries]);
    }

    public function save()
    {
        $name = $this->post('name');
        $subsecretary = $this->post('subsecretary_id');

        if (!$name || !$subsecretary) {
            $this->setMessage(TypeAlert::Warning, 'Los campos son requeridos para crear una unidad administrativa');
            return header('location: /auth/administrative-unit/create');
        }

        $existSubsecretary = SubSecretary::findOne($subsecretary);

        if (!$existSubsecretary) {
            $this->setMessage(TypeAlert::Warning, 'La subsecretaria no es correcta o no esta disponible');
            return header('location: /auth/administrative-unit/create');
        }


        $administrative = new AdministrativeUnit();
        $administrative->save($name, $subsecretary);

        $this->setMessage(TypeAlert::Warning, 'La subsecretaria no es');
        return header('location: /auth/administrative-unit');
    }

}
