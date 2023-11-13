<?php 

namespace App\traits;


trait QueryParamsTrait {

    public function getQueryParams(string $key) {
        return $key;
    }

    public function get(String $param)
    {
        if (!isset($_GET[$param])) return null;

        return $_GET[$param];
    }



    public function getParams($params)
    {
        if (!isset($_GET)) return;

        $queryString;

        foreach( $_GET as $key => $query ) {
            $queryString .= "$key =  $query";
        }

        var_dump($queryString);
        die();
    }


}