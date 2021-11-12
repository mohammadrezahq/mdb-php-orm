<?php

namespace Mor\Mdb\Inc;

interface Base 
{

    public function __construct($dbname, $username = "root", $password = "", $server = "localhost", $charset = "utf8mb4");

    public function table($table);

    public function where($column, $value, $operator = "=");

    public function whereArray(array $array);

    public function orWhere($column, $value, $operator = "=");

    public function getAll($cols = "*", int $limit = 0);

    public function first($cols = "*");

    public function last($cols = "*");

    public function order($by, $value = "ASC");

    public function insert(array $data);

    public function update(array $data);

    public function delete();

    public function createTable(string $tableName, array  $args);

    public function countOfRows();


}