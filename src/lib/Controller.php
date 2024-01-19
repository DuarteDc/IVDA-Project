<?php

namespace App\lib;

use App\lib\View;
use App\lib\Middleware;
use App\traits\AuthTrait;
use App\traits\MailTrait;
use App\traits\PDFTrait;
use Bramus\Router\Router;
use ErrorException;
use ReflectionClass;
use ReflectionMethod;

class Controller
{
    use AuthTrait, PDFTrait, MailTrait;

    private View $view;

    private array $status = [
        200 => '200 OK',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        422 => '422 Unprocessable Entity',
        403 => '403 Forbidden',
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

    protected function request()
    {
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

        return $_GET[$param];
    }

    protected function response($data, $status = 200)
    {

        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header("Content-Type: application/json;  charset=UTF-8");

        http_response_code($status);

        header('Status: ' . $this->status[$status]);

        echo json_encode($data);
        exit();
    }

    // private function getNamespace()
    // {
    //     return get_class($this);
    // }

    // private function validateMethos($classMethods, $methods) {
    //     return array_filter($classMethods, fn($method) => in_array($method->name, $methods));
    // }

    // protected function middleware(array $methods, $middleware)
    // {
    //     if(get_parent_class($middleware) != Middleware::class && !class_exists($middleware)) return new ErrorException("Provide a valid class");

    //     $classMethods = $this->validateMethos($this->getClassMethods(), $methods);
    //     $midd = new $middleware;

    //     $this->response($GLOBALS['router']);
    //     print_r($GLOBALS);

        
    //     die();

    // }

    // private function getClassMethods() {
        
    //     $namespace = $this->getNamespace();
    //     $class = new ReflectionClass($namespace);
    //     $publicMethods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

    //     return array_filter($publicMethods, fn ($method) => $method->class === $namespace);
    // }

    // public function __call($name, $arguments)
    // {
    //     call_user_func_array([$this, $name], $arguments);
    // }

}
