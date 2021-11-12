<?php

namespace Mor\Mdb;

// Get driver here
use Mor\Mdb\Inc\Mysql as DB;

class Mdb {

    protected static $database = [
        "server" => "localhost",
        "name" => "mafia",
        "username" => "root",
        "password" => "",
        "charset" => "utf8mb4"
    ];
    
    public static function __callStatic(string $method, array $arguments) {

        $database = self::$database;

        $instance = new DB($database['name'], $database['username'], $database['password'], $database['server'], $database['charset']);

        if ( method_exists($instance, $method) ) {

            return $instance->{$method}(...$arguments);

        }

        exit;

    }

}