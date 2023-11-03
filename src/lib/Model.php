<?php

namespace App\lib;
use App\lib\Database;

class Model
{

    private readonly Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function query(String $query)
    {
        return $this->db->connect()->query($query);
    }

    public function prepare(String $query)
    {
        return $this->db->connect()->prepare($query);
    }

    // protected function returnInstanceOf($instanceOf) {
    //     $arr = json_decode(json_encode ( $instanceOf ));
    //     return json_decode(json_encode($arr));
    // }   

}