<?php

namespace App\lib;

use App\emuns\TypeAlert;
use App\lib\View;
use App\traits\AuthTrait;

class Controller
{
    use AuthTrait;

    private View $view;

    private array $status = [
        200 => '200 OK',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        422 => 'Unprocessable Entity',
        404 => '404 Not Found',
        500 => '500 Internal Server Error'
    ];

    public function __construct()
    {
        $this->view = new View;
    }

    public function render(String $name, array $data = [])
    {
        $this->view->render($name, $data);
    }

    public function setMessage(TypeAlert $key, string $message)
    {
        $this->view->setMessage($key, $message);
    }

    protected function request() {
        $data = file_get_contents('php://input');
        return json_decode($data, true);
    }

    protected function post(String $param)
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        if (!isset($data[$param])) return null;

        return $data[$param];
    }

    protected function get(String $param)
    {
        if (!isset($_GET[$param])) return null;

        return json_decode($_GET[$param]);
    }

    protected function response( $data, $status = 200 ) {
        
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header("Content-Type: application/json");

        http_response_code($status);

        header('Status: '.$this->status[$status]);

        echo json_encode($data);
        exit();
    }

}
