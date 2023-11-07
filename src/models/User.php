<?php

namespace App\models;

use App\lib\Database;
use App\lib\Model;
use DatePeriod;
use DateTime;
use PDO;
use PDOException;
use Reflection;
use ReflectionClass;

class User extends Model
{
    public readonly string $id;
    public readonly string $name;
    public readonly string $last_name;
    public readonly string $email;
    public readonly string $password;
    public readonly string $created_at;
    public readonly bool $status;

    public function __construct()
    {
        parent::__construct();
    }

    private function getHashedPassword(string $password)
    {
        return password_hash($password, 'PASSWORD_DEFAULT', ['cost' => 10]);
    }

    public static function find($page = 1)
    {
        try {
            $db = new Model();

            $totalRecordPerPage = 10;
            $count = $db->query('SELECT count(*) FROM users')->fetchColumn();
            $totalPages = ceil($count / $totalRecordPerPage);
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            $query = $db->query("SELECT * FROM users ORDER BY id ASC LIMIT $totalRecordPerPage OFFSET $startingLimit");
            if ($query->rowCount() > 0) return ['users' => $query->fetchAll(PDO::FETCH_CLASS, self::class), 'totalPages' =>  $totalPages];
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function findAll() {
        try {
            $db = new Model();
            $query = $db->query('SELECT * FROM users Where status = true');
            return $query->rowCount();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public static function findByEmail(string $email)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM users Where email = :email');
            $query->execute([
                'email' => $email
            ]);

            if ( $query->rowCount() > 0 ) return $query->fetchObject(__CLASS__);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function verifyPassword(string $password, string $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    public function getUserByEmail()
    {
        try {
            $query = $this->prepare('SELECT * FROM users Where email = :email');
            $query->execute(['email' => $this->email]);
            return $query->fetchObject();
        } catch (PDOException $e) {
            echo $e;
        }
    }

}
