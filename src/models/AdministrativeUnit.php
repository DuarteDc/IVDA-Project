<?php 

namespace App\models;

use App\lib\Model;
use PDO;
use PDOException;

class AdministrativeUnit extends Model {


    public readonly string $id;
    public readonly string $name;
    public readonly bool $status;
    public readonly string $subsecretary_id;
    public readonly string $created_at;

    public function __construct() {
        parent::__construct();    
    }

    public static function findOne($id)
    {
        try {
            $db = new Model();
            $query = $db->prepare('SELECT * FROM administrative_units Where status = true AND id = :id');
            $query->execute([ 'id' => $id ]);

            if ($query->rowCount() > 0) 
                return $query->fetchObject(__CLASS__);

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

            $count = $db->query("SELECT count(*) FROM administrative_units WHERE status = {$type}")->fetchColumn();

            $totalPages = ceil($count / $totalRecordPerPage);
            if ($totalPages < $page) $page = $totalPages;
            $startingLimit = ($page - 1) * $totalRecordPerPage;

            $query = $db->query("SELECT administrative_units.id , administrative_units.name, administrative_units.status, administrative_units.created_at, subsecretaries.name  as subsecretary_id FROM administrative_units JOIN subsecretaries on subsecretaries.id = administrative_units.subsecretary_id Where administrative_units.status = {$type} ORDER BY administrative_units.id DESC LIMIT $totalRecordPerPage OFFSET $startingLimit");
            
            if ($query->rowCount() > 0) return ['administrative_units' => $query->fetchAll(PDO::FETCH_CLASS, self::class), 'totalPages' =>  $totalPages];

            return ['administrative_units' => [], 'totalPages' => $totalPages];
        } catch (PDOException $e) {
            return ['administrative_units' => [], 'totalPages' => 0];
        }
    }

    public function save(string $name, string $subsecretary_id)
    {
        try {
            $query = $this->prepare('INSERT INTO administrative_units(name, subsecretary_id) values(:name, :subsecretary_id)');
            return $query->execute(['name' => $name, 'subsecretary_id' => $subsecretary_id]);
        } catch (\Throwable $th) {
            return false;
        }
    }



}