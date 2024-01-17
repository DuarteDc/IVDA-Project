<?php

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;

class DependencyInventoryLocationTypeFile extends Model
{

    public readonly string  $id;
    public $dependency_id;
    public $inventory_id;
    public $location_id;
    public $type_file_id;
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
            $query = $db->prepare('SELECT * FROM dependency_inventory_location_type_file Where id = :id');
            $query->execute(['id' => $id]);

            if ($query->rowCount() > 0) return $query->fetchObject(self::class);

            return [false];
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function save(string $dependencyId, string $inventoryId, string $locationId, string $typeFileId)
    {
        try {
            $db = new Model();
            $query = $db->prepare('INSERT INTO dependency_inventory_location_type_file(dependency_id, inventory_id, location_id, type_file_id) VALUES (:dependency_id, :inventory_id, :location_id, :type_file_id)');
            $query->execute(['dependency_id' => $dependencyId, 'inventory_id' => $inventoryId, 'location_id' => $locationId, 'type_file_id' => $typeFileId]);

             return $query->fetchColumn();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function Where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM dependency_inventory_location_type_file WHERE {$strQuery}");

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
            $db->query("UPDATE dependency_inventory_location_type_file SET body = '$body' WHERE id = $id");
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function getDataRelations($inventory)
    {
        try {
            $db = new Model;
            $inventory->inventory_id = $db->query("SELECT id, status, start_date FROM inventories WHERE id = {$inventory->inventory_id}")->fetchObject(Inventory::class);
            $inventory->dependency_id = $db->query("SELECT id, name, code FROM dependencies WHERE id = {$inventory->dependency_id}")->fetchObject(Dependency::class);
            $inventory->location_id = $db->query("SELECT id, name FROM locations WHERE id = {$inventory->location_id}")->fetchObject(Location::class);
            $inventory->type_file_id = $db->query("SELECT id, name FROM type_files WHERE id = {$inventory->type_file_id}")->fetchObject(TypeFile::class);
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
            $db->query("UPDATE dependency_inventory_location_type_file $query Where id = $id");
            self::findOne($id);
        } catch (PDOException $th) {
            return false;
        }
    }
}
