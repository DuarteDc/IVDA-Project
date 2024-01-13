<?php

namespace App\lib;

use App\lib\Controller;
use App\models\Dependency;
use App\models\User;
use Faker\Factory;

class Seed extends Controller
{

    public function runSeedDependencies()
    {
        if ($_ENV['ENV'] === 'production') return $this->response(['message' => 'No se ha podido ejecuatar el script porque se encuentra actualmente en producción']);

        $data = file_get_contents(__DIR__ . '/../static-data/dependencies.json');

        $query = 'INSERT INTO dependencies(name, code) values';
        foreach (json_decode($data) as $key => $value) {
            $query .= "('{$value->name}', '{$value->code}'),";
        }
        $query = rtrim($query, ', ');

        $dependencies = Dependency::runSeed();
        $dependencies ? $this->response(['message' => 'Las dependencias se crearon correctamente']) : $this->response(['message' => 'Error al crear las dependencias']);
    }


    public function runSeedUsers()
    {
        if ($_ENV['ENV'] === 'production') return $this->response(['message' => 'No se ha podido ejecuatar el script porque se encuentra actualmente en producción']);
        $dependencies = Dependency::findAll();

        $faker = Factory::create();
        $users = array_map(function ($dependency) use ($faker) {
            return [
                'name' => $faker->userName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->email(),
                'password' => password_hash('password', PASSWORD_BCRYPT, ['cost' => 12]),
                'dependency_id' => $dependency->id,
                'role' => $faker->randomElement(['0', '1']),
            ];
        }, $dependencies);

        $users = User::runSeed($users);

        $users ? $this->response(['message' => 'Los usuarios se crearon correctamente']) : $this->response(['message' => 'Error al crear los usuarios']);
    }
}
