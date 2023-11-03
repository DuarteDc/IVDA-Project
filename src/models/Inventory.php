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
    public static function find()
    {
        try {
            $db = new Model();
            $query = $db->query('SELECT * FROM inventories');
            if ($query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_ASSOC);
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
