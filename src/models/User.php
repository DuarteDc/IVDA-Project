<?php

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;
use App\traits\AuthTrait;

class User extends Model
{

    const ADMIN = 0;
    const SUBADMIN = 1;

    use AuthTrait;

    public readonly string $id;
    public readonly string $name;
    public readonly string $last_name;
    public readonly string $email;
    public string $password;
    public readonly string $created_at;
    public readonly bool $status;
    public readonly string $role;
    public $dependency_id;

    public function __construct()
    {
        parent::__construct();
    }

    public static function findOne($id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM users Where id = :id');
            $query->execute(['id' => $id]);

            if ($query->rowCount() <= 0) return false;

            $user = $query->fetchObject(self::class);
            return $user;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function where(string $strQuery)
    {
        try {
            $db = new Model();
            $query = $db->query("SELECT * FROM users WHERE $strQuery");
            if ($query->rowCount() > 0) return $query->fetchObject(self::class);
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function find($page = 1)
    {
        try {
            $db = new Model();
            $page = abs($page);
            $totalRecordPerPage = 10;
            $count = $db->query('SELECT count(*) FROM users')->fetchColumn();
            $totalPages = ceil($count / $totalRecordPerPage);
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            if ($totalPages < $page) $page = $totalPages;
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            $query = $db->query("SELECT id, name, last_name, email, role, status, dependency_id FROM users WHERE id <> " . self::auth()->id . "ORDER BY id ASC LIMIT $totalRecordPerPage OFFSET $startingLimit");
            if ($query->rowCount() > 0) return ['users' => $query->fetchAll(PDO::FETCH_CLASS, self::class), 'totalPages' =>  $totalPages];
            return ['users' => [], 'totalPages' =>  0];
        } catch (PDOException $e) {
            return ['users' => [], 'totalPages' =>  0];
        }
    }

    public static function findAll()
    {
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

            if ($query->rowCount() > 0) return $query->fetchObject(self::class);

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


    public static function UpdateOne(string $id, array $params)
    {
        try {
            if (isset($params['role'])) unset($params['role']);
            $db = new Model();
            $query = 'SET ';
            foreach ($params as $key => $value) {
                if (strlen($value)  > 0) {
                    if ($key === 'password') {
                        $query .= "{$key} = '" . self::getHashedPassword($value) . "', ";
                    } else {
                        $query .= "{$key} = '{$value}', ";
                    }
                }
            }
            $query = rtrim($query, ', ');
            $db->query("UPDATE users $query Where id = $id");
            return self::findOne($id);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function save(string $name, string $last_name, string $email, string $password, string $dependencyId, $role = 1)
    {
        try {
            $passwordHash = $this->getHashedPassword($password);
            $query = $this->prepare('INSERT INTO users(name, last_name, email, password, dependency_id, role) VALUES (:name, :last_name, :email, :password, :dependency_id, :role)');
            return $query->execute(['name' => $name, 'last_name' => $last_name, 'email' => $email, 'password' => $passwordHash, 'dependency_id' => $dependencyId, 'role' => $role]);
        } catch (\Throwable $th) {
            return false;
        }
    }


    public static function disableUser(string $id)
    {
        try {
            $db = new Model;
            return $db->query("UPDATE users SET status = false WHERE id = $id");
        } catch (\Throwable $th) {
            return false;
        }
    }


    public static function activeUser(string $id)
    {
        try {
            $db = new Model;
            return $db->query("UPDATE users SET status = true WHERE id = $id");
        } catch (\Throwable $th) {
            return false;
        }
    }
    public static function countUsers()
    {
        try {
            $db = new Model();
            return $db->query("SELECT count(*) FROM users")->fetchColumn();
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function runSeed(array $users)
    {
        try {
            $query = 'INSERT INTO users(name, last_name, email, password, dependency_id, role) values';
            $db = new Model();
            foreach ($users as $key => $user) {
                $query .= "('{$user["name"]}','{$user["last_name"]}', '{$user["email"]}', '{$user["password"]}', '{$user["dependency_id"]}', '{$user["role"]}'),";
            }
            $query = rtrim($query, ', ');

            return $db->query($query);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    private static function getHashedPassword(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}
