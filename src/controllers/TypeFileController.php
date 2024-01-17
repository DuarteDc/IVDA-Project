<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\TypeFile;

class TypeFileController extends Controller
{

    public function index()
    {
        $typeFiles = TypeFile::findAll();
        $this->response(['type_files' => $typeFiles]);
    }

    public function save()
    {
        $name = $this->post('name');

        if (!$name) return $this->response(['message' => 'Para poder crear un tipo de archivo es necesario el nombre'], 400);

        $name = trim(ucwords($name));

        $typeFile = TypeFile::where("name = '$name'");
        if ($typeFile) return $this->response(['message' => 'Ya existe un tipo de archivo con ese nombre']);

        $typeFile = new TypeFile;
        $typeFile = $typeFile->save($name);

        $this->response(['type_file' => $typeFile]);
    }
}
