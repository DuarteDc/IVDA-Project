<?php

namespace App\controllers;

use App\emuns\TypeAlert;
use App\lib\Controller;
use App\models\SubSecretary;

class SubSecretaryController extends Controller
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

        $data = SubSecretary::find($page, $type);
        $this->response(['subsecretaries' => $data['subsecretaries'], 'page' => $page, 'totalPages' => $data['totalPages']]);
    }

    public function create()
    {
        $this->render('subsecretary/create');
    }

    public function save()
    {
        $name = $this->post('name');

        if (!$name) {
            $this->setMessage(TypeAlert::Warning, 'El nombre es requerido para crear una subsecretaria');
            return header('location: /auth/subsecretaries');
        }

        $name = trim(strtoupper($name));

        $existSubsecretary = SubSecretary::Where("name = $name");

        if ($existSubsecretary) {
            $this->setMessage(TypeAlert::Warning, 'Ya existe una subsecretaria con ese nombre');
            return header('location: /auth/subsecretaries');
        }

        $subsecretary = new SubSecretary();
        $subsecretary->save($name);

        $this->setMessage(TypeAlert::Success, 'La subsecretaria se creo con exito');
        return header('location: /auth/subsecretaries');
    }

    public function show(string $id)
    {
        $subsecretary = SubSecretary::findOne($id);
        $this->render('/subsecretary/show', ['subsecretary' => $subsecretary]);
    }


    public function getAll()
    {
        $subsecretaries = SubSecretary::WhereStatus(true);
        $this->response(['subsecretaries' => $subsecretaries]);
    }


    public function disable(string $id)
    {
        $subsecretary = SubSecretary::findOne($id);
    }
}
