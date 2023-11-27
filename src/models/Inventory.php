<?php

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;

class Inventory extends Model
{

    public readonly string  $id;
    public readonly string  $name;
    public readonly string  $code;
    public readonly bool    $status;
    public readonly string  $user_id;
    public readonly string  $created_at;    

    public function __construct()
    {
        parent::__construct();
    }

    public static function findOne(string $id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM inventories Where id = :id');
            $query->execute(['id' => $id]);

            if ($query->rowCount() > 0) return $query->fetchObject(__CLASS__);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function find($page = 1)
    {
        try {
            $db = new Model();
            $page = abs($page);

            $totalRecordPerPage = 10;
            $count = $db->query('SELECT count(*) FROM inventories')->fetchColumn();
            $totalPages = ceil($count / $totalRecordPerPage);
            if ($totalPages < $page) $page = $totalPages;
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            $query = $db->query("SELECT * FROM inventories ORDER BY id ASC LIMIT $totalRecordPerPage OFFSET $startingLimit");
            if ($query->rowCount() > 0) return ['inventories' => $query->fetchAll(PDO::FETCH_CLASS, self::class), 'totalPages' =>  $totalPages];
            return ['inventories' => [], 'totalPages' => $totalPages];
        } catch (PDOException $e) {
            return ['inventories' => [], 'totalPages' => 0];
        }
    }

    public static function Where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM inventories WHERE {$strQuery}");

            if ($query->rowCount() > 0) return $query->fetchObject(__CLASS__);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function save(string $name, string $code, string $user_id) {
        try{
            $query = $this->insert('INSERT INTO inventories(name, code, user_id) VALUES (:name, :code, :user_id)  RETURNING id', 
            [ 'name' => $name, 'code' => $code, 'user_id' =>  $user_id]);
            return $query;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function UpdateOne(int $id, array $params)
    {
        try {
            $db = new Model();
            $query = 'SET ';
            foreach ($params as $key => $value) {
                if (strlen($value)  > 0)  $query .= "{$key} = '{$value}', ";
            }
            $query = rtrim($query, ', ');
            return $db->query("UPDATE inventories $query Where id = $id");
        } catch (PDOException $th) {
            return false;
        }
    }
}
