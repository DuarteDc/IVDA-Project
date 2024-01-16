<?php

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;

class Location extends Model
{

    public readonly string $id;
    public readonly string $name;
    public readonly string $created_at;

    public function __construct()
    {
        parent::__construct();
    }

    public static function findAll()
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM locations");
            return $query->fetchAll(PDO::FETCH_CLASS, static::class);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function save(string $name)
    {
        try {
            $query = $this->prepare('INSERT INTO locations (name) values(:name)');
            $id = $query->execute(['name' => $name]);
            return $this->where("id = $id");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM locations WHERE $strQuery");
            if ($query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_CLASS, static::class);
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
