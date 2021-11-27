<?php

namespace Mor\Mdb\Inc;

interface Database {

    public function __construct();

    public function table(String $table);

    public function where($column, $value, $operator = "=");

    public function orWhere($column, $value, $operator = "=");

    public function whereArray(Array $array);
    
    public function getAll($cols = "*", int $limit = 0);

    public function first($cols = "*");

    public function last($cols = "*");

    public function order($by, $value = "ASC");

    public function insert(Array $data);

    public function update(Array $data);

    public function delete();

    public function createTable(String $tableName, Array $data);

    public function countOfRows();

}