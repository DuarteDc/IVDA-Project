<?php

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;

class DependencyInventory extends Model
{

    public readonly string  $id;
    public $dependency_id;
    public $inventory_id;
    public string | null | array $body;
    public readonly string  $created_at;

    public function __construct()
    {
        parent::__construct();
    }

    public static function findOne(string $id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM dependency_inventory Where id = :id');
            $query->execute(['id' => $id]);

            if ($query->rowCount() > 0) return $query->fetchObject(self::class);

            return [false];
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function save(string $dependency_id, string $inventory_id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('INSERT INTO dependency_inventory(dependency_id, inventory_id) VALUES (:administrative_unit_id, :inventory_id)');
            $query->execute(['administrative_unit_id' => $dependency_id, 'inventory_id' => $inventory_id]);

            if ($query->rowCount() > 0) return $query->fetchObject(self::class);
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function Where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM dependency_inventory WHERE {$strQuery}");

            if ($query->rowCount() > 0) return $query->fetchObject(__CLASS__);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function updateBody(string $id, string $body)
    {
        try {
            $db = new Model;
            $db->query("UPDATE dependency_inventory SET body = '$body' WHERE id = $id");
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function getDataRelations($inventory)
    {
        try {
            $db = new Model;
            $inventory->inventory_id = $db->query("SELECT id, name, status, code FROM inventories WHERE id = {$inventory->inventory_id}")->fetchObject(Inventory::class);
            $inventory->dependency_id = $db->query("SELECT id, name FROM dependencies WHERE id = {$inventory->dependency_id}")->fetchObject(Dependency::class);
            return $inventory;
        } catch (\Throwable $th) {
            return false;
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
            $db->query("UPDATE dependency_inventory $query Where id = $id");
            self::findOne($id);
        } catch (PDOException $th) {
            return false;
        }
    }
}
