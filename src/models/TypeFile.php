<?php

namespace App\models;
use App\lib\Model;
use PDO;
use PDOException;

class TypeFile extends Model {
    
    public readonly string $id;
    public readonly string $name;
    public readonly string $created_at;

    public function __construct() {
        parent::__construct();
    }

    public static function findAll()
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM type_files");
            return $query->fetchAll(PDO::FETCH_CLASS, static::class);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function save(string $name)
    {
        try {
            $query = $this->prepare('INSERT INTO type_files (name) values(:name)');
            $id = $query->execute(['name' => $name]);
            return $this->findOne($id);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public static function where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM type_files WHERE $strQuery");
            if ($query->rowCount() > 0) return $query->fetchObject(static::class);
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function findOne(string $id)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM type_files WHERE id = $id");
            return $query->fetchObject(static::class);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


}