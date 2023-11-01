<?php

namespace App\models;

use App\lib\Model;
use PDOException;

class User extends Model
{
    public function __construct(private readonly string $email, private readonly string $password)
    {
        parent::__construct();
    }

    private function getHashedPassword(String $password)
    {
        return password_hash($password, 'PASSWORD_DEFAULT', ['cost' => 10]);
    }

    public function verifyPassword(String $hashedPassword) {
        return password_verify($this->password, $hashedPassword);
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
}
