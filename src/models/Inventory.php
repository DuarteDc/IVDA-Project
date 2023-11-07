<?php

namespace App\models;

use App\lib\Model;
use DateTime;
use PDO;
use PDOException;

class Inventory extends Model
{

    public readonly string $id;
    public readonly string $name;
    public readonly string $start_date;
    public readonly null $end_date;
    public readonly bool $status;

    public function __construct()
    {
        parent::__construct();
    }

    public static function findOne(string $id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM inventiries Where id = :id');
            $query->execute(['id' => $id]);

            if ($query->rowCount() > 0) return $query->fetchObject(__CLASS__);

            return 0;
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function find($page = 1)
    {
        try {
            $db = new Model();

            $totalRecordPerPage = 10;
            $count = $db->query('SELECT count(*) FROM inventories')->fetchColumn();
            $totalPages = ceil($count / $totalRecordPerPage);
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            $query = $db->query("SELECT * FROM inventories ORDER BY id ASC LIMIT $totalRecordPerPage OFFSET $startingLimit");
            if ($query->rowCount() > 0) return ['inventories' => $query->fetchAll(PDO::FETCH_CLASS, self::class), 'totalPages' =>  $totalPages];
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

}
