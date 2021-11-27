<?php

namespace Mor\Mdb\Inc;

use Mor\Mdb\Inc\ErrorHandler;

class Base 
{

    use ErrorHandler;

    protected $db;

    protected $table;

    protected $where;

    protected $query;

    protected $order;
    
    /**
     * Get array and turn into object
     * @param array $array
     * @return object
     */
    protected function turnIntoObject(array $array) {

        return json_decode(json_encode($array));

    }

}