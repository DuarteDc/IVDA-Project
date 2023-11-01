<?php

error_reporting(E_ALL);

ini_set('ignore_repeated_errors', FALSE);

ini_set('display_errors', TRUE);

ini_set('log_errors', TRUE);

ini_set("error_log", "./../php-error.log");

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/lib/routes.php';