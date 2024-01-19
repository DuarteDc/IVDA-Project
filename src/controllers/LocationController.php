<?php

namespace App\controllers;

use App\lib\Controller;
use App\middlewares\HasAdminRole;
use App\models\Location;

class LocationController extends Controller
{
    

    public function index()
    {
        $locations = Location::findAll();   
        $this->response(['locations' => $locations], 200);
    }

    public function save()
    {
        $name = $this->post('name');

        if (!$name) return $this->response(['message' => 'Para poder crear una ubicación física es necesario el nombre'], 400);

        $name = trim(ucwords($name));

        $location = Location::where("name = '$name'");
        if ($location) return $this->response(['message' => 'Ya existe una ubicación con ese nombre']);

        $location = new Location;
        $location = $location->save($name);

        $this->response(['location' => $location]);
    }
}
