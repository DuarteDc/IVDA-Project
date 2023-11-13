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
    public readonly AdministrativeUnit $administrativeUnits;

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

            if ($query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_CLASS, self::class);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function find(string $page = "1", bool $type = true)
    {
        try {
            $db = new Model();
            $page = abs($page);

            $type = json_encode($type);

            $totalRecordPerPage = 10;

            $count = $db->query("SELECT count(*) FROM subsecretaries WHERE status = {$type}")->fetchColumn();

            $totalPages = ceil($count / $totalRecordPerPage);
            if ($totalPages < $page) $page = $totalPages;
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            $query = $db->query("SELECT * FROM subsecretaries Where status = {$type} ORDER BY id DESC LIMIT $totalRecordPerPage OFFSET $startingLimit");
            
            if ($query->rowCount() > 0) return ['subsecretaries' => $query->fetchAll(PDO::FETCH_CLASS, self::class), 'totalPages' =>  $totalPages];

            return ['subsecretaries' => [], 'totalPages' => $totalPages];
        } catch (PDOException $e) {
            return ['subsecretaries' => [], 'totalPages' => 0];
        }
    }

    public static function Where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM subsecretaries :query');
            $query->execute(['query' => $strQuery]);

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
            $query = $this->insert('INSERT INTO inventories(name) VALUES (:name)  RETURNING id', ['name' => $name]);
            return $query;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    public function xd() {
        echo "xd";
    }

}
