<?php

namespace App\lib;

use App\emuns\TypeAlert;
use App\lib\View;
use App\traits\AuthTrait;

class Controller
{

    private View $view;
    use AuthTrait;

    public function __construct()
    {
        $this->view = new View;
    }

    public function render(String $name, array $data = [])
    {
        $this->view->render($name, $data);
    }

    public function setMessage(TypeAlert $key, string $message) {
        $this->view->setMessage($key, $message);
    }

    protected function post(String $param)
    {
        if (!isset($_POST[$param])) return null;

        return $_POST[$param];
    }

    protected function get(String $param)
    {
        if (!isset($_GET[$param])) return null;

        return $_GET[$param];
    }
}
