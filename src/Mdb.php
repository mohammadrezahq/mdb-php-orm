<?php

namespace Mor\Mdb;

use Exception;
use Symfony\Component\Dotenv\Dotenv;

class Mdb {

    protected function connect() {

        $dotenv = new Dotenv();

        try {
            $dotenv->load(__DIR__.'\.env');
        } catch (Exception $e) {
            die($e);
        }

    }
    
    public static function __callStatic(string $method, array $arguments) {

        if (!isset($_ENV['DB_USERNAME'])) {

            (new Self)->connect();

        }
        
        $driver = '\Mor\Mdb\Db\\' . $_ENV['DB_DRIVER'];

        if (!class_exists($driver)) {

            die('Driver is not supported.');

        }

        $instance = new $driver();


        if ( method_exists($instance, $method) ) {

            return $instance->{$method}(...$arguments);

        }

        exit;

    }

}