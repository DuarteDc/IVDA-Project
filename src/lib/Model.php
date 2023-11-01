<?php

namespace App\lib;
use App\lib\Database;

class Model
{

    private Database $db;

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
}