<?php

namespace App\models;

use App\lib\Database;
use App\lib\Model;
use PDOException;

class User extends Model
{

    public string $id;
    public string $name;
    public string $lastname;
    public string $role;

    public function __construct(private readonly string $email)
    {
        parent::__construct();
        $this->id = '';
        $this->name = '';
        $this->lastname = '';
        $this->role = '';
    }

    private function getHashedPassword(String $password)
    {
        return password_hash($password, 'PASSWORD_DEFAULT', ['cost' => 10]);
    }

    public static function findByEmail(String $email)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM users Where email = :email');
            $query->execute([
                'email' => $email
            ]);
            return $query->rowCount() > 0 ? new User($query->fetchObject()->id) : false;
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
            $query->execute([
                'email' => $this->email
            ]);
            return $query->fetchObject();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function setUser($user)
    {

        $this->id = $user->id;
        $this->name = $user->id;
        $this->lastname = $user->id;
        $this->role = $user->id;

        return $this;
    }
}
