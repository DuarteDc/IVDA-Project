<?php

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;

class AdministrativeUnitInventorySubsecretary extends Model
{

    public readonly string  $id;
    public $administrative_unit_id;
    public $inventory_id;
    public $subsecretary_id;
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
            $query = $db->prepare('SELECT * FROM administrative_unit_inventories_subsecretary Where id = :id');
            $query->execute(['id' => $id]);

            if ($query->rowCount() > 0) return $query->fetchObject(self::class);

            return [false];
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function save(string $administrative_unit_id, string $inventory_id, string $subsecretary_id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('INSERT INTO administrative_unit_inventories_subsecretary(administrative_unit_id, inventory_id, subsecretary_id) VALUES (:administrative_unit_id, :inventory_id, :subsecretary_id)');
            $query->execute(['administrative_unit_id' => $administrative_unit_id, 'inventory_id' => $inventory_id, 'subsecretary_id' => $subsecretary_id]);

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
            $query = $db->query("SELECT * FROM administrative_unit_inventories_subsecretary WHERE {$strQuery}");

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
            $db->query("UPDATE administrative_unit_inventories_subsecretary SET body = '$body' WHERE id = $id");
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function getDataRelations($inventory)
    {
        try {
            $db = new Model;
            $inventory->subsecretary_id = $db->query("SELECT id, name FROM subsecretaries WHERE id = {$inventory->subsecretary_id}")->fetchObject(SubSecretary::class);
            $inventory->inventory_id = $db->query("SELECT id, name, status, code FROM inventories WHERE id = {$inventory->inventory_id}")->fetchObject(Inventory::class);
            $inventory->administrative_unit_id = $db->query("SELECT id, name FROM administrative_units WHERE id = {$inventory->administrative_unit_id}")->fetchObject(AdministrativeUnit::class);
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
            $db->query("UPDATE administrative_unit_inventories_subsecretary $query Where id = $id");
            self::findOne($id);
        } catch (PDOException $th) {
            return false;
        }
    }
}
