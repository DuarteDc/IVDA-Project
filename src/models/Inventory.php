<?php

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;

class Inventory extends Model
{

    public readonly string  $id;
    public readonly bool    $status;
    public readonly string  $user_id;
    public readonly string  $start_date;
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

    public static function findByUser($page, int $user_id)
    {
        try {
            $db = new Model();
            $page = abs($page);

            $totalRecordPerPage = 10;
            $count = $db->query("SELECT count(*) FROM inventories WHERE user_id = $user_id")->fetchColumn();
            $totalPages = ceil($count / $totalRecordPerPage);
            if ($totalPages < $page) $page = $totalPages;
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            $query = $db->query("SELECT * FROM inventories WHERE user_id = $user_id ORDER BY id ASC LIMIT $totalRecordPerPage OFFSET $startingLimit");
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

    public function save(string $userId, string $startDate)
    {
        try {
            (string)$id = $this->insert('INSERT INTO inventories(user_id, start_date) VALUES (:user_id, :start_date) returning id', ['user_id' =>  $userId, 'start_date' => $startDate]);
            return $this->findOne($id);
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

    public function attachData($dependencyId, $inventoryId, $locationId, $typeFileId)
    {
        try {
            $relation = new DependencyInventoryLocationTypeFile;
            return $relation->save((string)$dependencyId, (string) $inventoryId, (string) $locationId, (string) $typeFileId);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function countInventories()
    {
        try {
            $db = new Model();
            return $db->query("SELECT count(*) FROM inventories")->fetchColumn();
        } catch (\Throwable $th) {
            return 0;
        }
    }
}
