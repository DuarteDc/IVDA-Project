<?php
namespace App\lib;

use App\traits\AuthTrait;

class Middleware {
    use AuthTrait;

    protected static array $status = [
        200 => '200 OK',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
    ];

    protected static function response( $data, $status = 200 ) {
        
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header("Content-Type: application/json");

        http_response_code($status);

        header('Status: '.self::$status[$status]);

        echo json_encode($data);
        exit();
    }
}