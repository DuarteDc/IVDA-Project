<?php

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;

class Dependency extends Model
{


    public readonly string $id;
    public readonly string $name;
    public readonly string $code;
    public readonly bool $status;
    public readonly string $created_at;

    public function __construct()
    {
        parent::__construct();
    }

    public static function findOne($id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM dependencies WHERE id = :id');
            $query->execute(['id' => $id]);

            if ($query->rowCount() > 0)
                return $query->fetchObject(__CLASS__);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function findAll()
    {
        try {
            $db = new Model();
            $query = $db->query('SELECT * FROM dependencies');
            return $query->fetchAll(PDO::FETCH_CLASS, static::class);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function find(string $page = "1")
    {
        try {

            $db = new Model();
            $page = abs($page);

            $totalRecordPerPage = 10;

            $count = $db->query("SELECT count(*) FROM dependencies")->fetchColumn();

            $totalPages = ceil($count / $totalRecordPerPage);
            if ($totalPages < $page) $page = $totalPages;
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            $query = $db->query("SELECT * FROM dependencies ORDER BY id DESC LIMIT $totalRecordPerPage OFFSET $startingLimit");

            if ($query->rowCount() > 0) return ['dependencies' => $query->fetchAll(PDO::FETCH_CLASS, self::class), 'totalPages' =>  $totalPages];

            return ['dependencies' => [], 'totalPages' => $totalPages];
        } catch (PDOException $e) {
            return ['dependencies' => [], 'totalPages' => 0];
        }
    }

    public function save(string $name, string $code)
    {
        try {
            $query = $this->prepare('INSERT INTO dependencies(name, code) values(:name, :code)');
            return $query->execute(['name' => $name, 'code' => $code]);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM dependencies WHERE $strQuery");
            if ($query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_CLASS, self::class);
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function WhereStatus(bool $type)
    {
        try {
            $db = new Model();
            $type = json_encode($type);
            $query = $db->query("SELECT * FROM dependencies WHERE status = {$type}");
            if ($query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_CLASS, self::class);
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function findByUser(string $user_id)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM dependencies WHERE status = true AND user_id = $user_id");
            if ($query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_CLASS, self::class);
            return [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function changeStatus(string $id, bool $status)
    {
        try {
            $db = new Model;
            $status = json_encode($status);
            return $db->query("UPDATE dependencies SET status = {$status} WHERE id = {$id}");
        } catch (\Throwable $th) {
            return false;
        }
    }


    public static function users($administrative_unit)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM users WHERE status = true AND administrative_unit_id = $administrative_unit->id");
            if ($query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_CLASS, User::class);
            return [];
        } catch (PDOException $e) {
            return [];
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
            $db->query("UPDATE dependencies $query Where id = $id");
            return self::findOne($id);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function withoutUsers()
    {
        try {
            $db = new Model;
            $query = $db->query("SELECT * FROM dependencies WHERE id NOT IN (SELECT dependency_id FROM users)");
            return $query->rowCount() > 0 ? $query->fetchAll(PDO::FETCH_CLASS, static::class) : [];
        } catch (\Throwable $th) {
            return [];
        }
    }


    public static function countDependencies()
    {
        try {
            $db = new Model();
            return $db->query("SELECT count(*) FROM dependencies")->fetchColumn();
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function runSeed()
    {
        try {
            $data = file_get_contents(__DIR__ . '/../static-data/dependencies.json');

            $query = 'INSERT INTO dependencies(name, code) values';
            $db = new Model();
            foreach (json_decode($data) as $key => $value) {
                $query .= "('{$value->name}', '{$value->code}'),";
            }
            $query = rtrim($query, ', ');

            return $db->query($query);
        } catch (PDOException $e) {
            return $e;
        }
    }
}
