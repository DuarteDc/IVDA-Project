<?php

namespace App\models;

use App\lib\Model;
use PDOException;

class Token extends Model
{

    public readonly string  $id;
    public readonly string  $email;
    public readonly string  $token;
    public readonly string  $expiration_date;


    public function __construct()
    {
        parent::__construct();
    }


    public static function findOne(string $id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM tokens Where id = :id');
            $query->execute(['id' => $id]);

            if ($query->rowCount() > 0) return $query->fetchObject(self::class);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM tokens WHERE $strQuery");
            if ($query->rowCount() > 0) return $query->fetchObject(self::class);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function save(string $token, string $email, string $expiration_date)
    {
        try {
            $query = $this->insert('INSERT INTO tokens(token, email, expiration_date) VALUES (:token, :email, :expiration_date)  RETURNING id', ['token' => $token, 'email' => $email, 'expiration_date' => $expiration_date]);
            return $query;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    public static function delete(string $id)
    {
        try {
            $db = new Model();
            $query = $db->query("DELETE FROM tokens WHERE id = $id");

            if ($query->rowCount() > 0) return $query->fetchObject(self::class);

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
