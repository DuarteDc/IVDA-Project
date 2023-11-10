<?php

namespace App\lib;
use App\lib\Database;
use PDO;

class Model
{

    private readonly Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function query(string $query)
    {
        return $this->db->connect()->query($query);
    }

    public function prepare(string $query)
    {
        return $this->db->connect()->prepare($query);
    }

    public function insert(string $query, array $fields) {
        $sql = $this->db->connect()->prepare($query);
        $sql->execute($fields);
        return $sql->fetchObject();
    }
}