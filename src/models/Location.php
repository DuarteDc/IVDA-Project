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
            (string)$id = $this->insert('INSERT INTO locations (name) values(:name) returning id', ['name' => $name]);
            return $this->findOne($id);
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

    public static function findOne(string $id)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM locations WHERE id = $id");
            return $query->fetchObject(static::class);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
