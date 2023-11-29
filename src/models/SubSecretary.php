<?php

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;

class SubSecretary extends Model
{

    public readonly string  $id;
    public readonly string  $name;
    public readonly bool    $status;
    public readonly string  $created_at;
    public readonly AdministrativeUnit $administrative_units;
    public readonly User $users;

    public function __construct()
    {
        parent::__construct();
    }

    public static function findOne(string $id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM subsecretaries Where id = :id');
            $query->execute(['id' => $id]);

            if ($query->rowCount() > 0) return $query->fetchObject(self::class);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function find(string $page = "1")
    {
        try {
            $db = new Model();
            $page = abs($page);

            $totalRecordPerPage = 10;

            $count = $db->query("SELECT count(*) FROM subsecretaries")->fetchColumn();

            $totalPages = ceil($count / $totalRecordPerPage);
            if ($totalPages < $page) $page = $totalPages;
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            $query = $db->query("SELECT * FROM subsecretaries ORDER BY id ASC LIMIT $totalRecordPerPage OFFSET $startingLimit");

            if ($query->rowCount() > 0) return ['subsecretaries' => $query->fetchAll(PDO::FETCH_CLASS, self::class), 'totalPages' =>  $totalPages];

            return ['subsecretaries' => [], 'totalPages' => $totalPages];
        } catch (PDOException $e) {
            return ['subsecretaries' => [], 'totalPages' => 0];
        }
    }

    public static function UpdateOne(string $id, array $params)
    {
        try {
            $db = new Model();
            $query = 'SET ';
            foreach ($params as $key => $value) {
                if (strlen($value)  > 0)  $query .= "{$key} = '{$value}', ";
            }
            $query = rtrim($query, ', ');
            $db->query("UPDATE subsecretaries $query Where id = $id");
            return self::findOne($id);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function Where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM subsecretaries WHERE {$strQuery}");


            if ($query->rowCount() > 0) return $query->fetchObject(__CLASS__);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function findAll()
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM subsecretaries WHERE status = true");
            if ($query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_CLASS, self::class);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function save(string $name)
    {
        try {
            $query = $this->insert('INSERT INTO subsecretaries(name) VALUES (:name)  RETURNING id', ['name' => $name]);
            return $query;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    public static function WhereStatus(bool $type)
    {
        try {
            $db = new Model();
            $type = json_encode($type);
            $query = $db->query("SELECT * FROM subsecretaries WHERE status = {$type}");
            if ($query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_CLASS, self::class);
            return [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function administrativeUnits(SubSecretary $subsecretary, bool $type = true)
    {
        try {
            if (!$subsecretary) return false;

            $type = json_encode($type);
            $db = new Model();
            $query = $db->query("SELECT * FROM administrative_units WHERE status = {$type} AND subsecretary_id = {$subsecretary->id}");
            return $query->fetchAll(PDO::FETCH_CLASS, AdministrativeUnit::class);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function users(SubSecretary $subsecretary)
    {
        try {
            if (!$subsecretary) return false;
            $db = new Model();
            $administrative_units = $subsecretary->administrativeUnits($subsecretary);
            if (!count($administrative_units) > 0) return [];
            $query = $db->query("SELECT * FROM users WHERE administrative_unit_id = {$administrative_units[0]->id}");
            return $query->fetchAll(PDO::FETCH_CLASS, User::class);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function inventories(SubSecretary $subsecretary)
    {
        try {
            if (!$subsecretary) return false;
            $db = new Model();
            $query = $db->query("SELECT * FROM administrative_unit_inventories_subsecretary WHERE subsecretary_id = {$subsecretary->id}");
            $relation =  $query->fetchAll(PDO::FETCH_CLASS, AdministrativeUnitInventorySubsecretary::class);

            $invetories = [];
            foreach ($relation as $key => $inventory) {
                $query = $db->query("SELECT * FROM inventories WHERE id = {$inventory->inventory_id}");
                array_push($invetories, $query->fetchObject(Inventory::class));
            }
            return $invetories;
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function disableSubsecretary(string $id)
    {
        try {
            $db = new Model;
            return $db->query("UPDATE subsecretaries SET status = false WHERE id = $id");
        } catch (\Throwable $th) {
            return false;
        }
    }


    public static function activeSubsecretary(string $id)
    {
        try {
            $db = new Model;
            return $db->query("UPDATE subsecretaries SET status = true WHERE id = $id");
        } catch (\Throwable $th) {
            return false;
        }
    }


    public static function countSubsecretaries()
    {
        try {
            $db = new Model();
            return $db->query("SELECT count(*) FROM subsecretaries")->fetchColumn();
        } catch (\Throwable $th) {
            return 0;
        }
    }
}
