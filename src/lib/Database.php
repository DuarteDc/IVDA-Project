<?php

namespace App\lib;

use Exception;
use PDO;
use PDOException;

class Database
{

    private readonly String $host;
    private readonly String $db;
    private readonly String $user;
    private readonly String $password;

    public function __construct()
    {
        $this->host     = $_ENV['HOST'];
        $this->db       = $_ENV['DB'];
        $this->user     = $_ENV['USER'];
        $this->password = $_ENV['PASSWORD'];

        if (!$this->host || !$this->db || !$this->user) return throw new Exception("Configure .env file");
    }

    public function connect(): PDO
    {
        try {
            $connection = "pgsql:host=" . $this->host . ";dbname=" . $this->db;

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            return new PDO(
                $connection,
                $this->user,
                $this->password,
                $options,
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
