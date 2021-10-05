<?php

class Msql
{
    private $db;

    private $table;

    private $where;

    private $query;

    private $order;


    /**
     * MSQL Construct
     * @param string $dbname <p>
     * Database name.
     * </p>
     * @param string $username <p>
     * Database username.
     * </p>
     * @param string $password <p>
     * Database password.
     * </p>
     * @param string $server <p>
     * Database server.
     * </p>
     * @param string $charset <p>
     * Database charset.
     * </p>
     */
    public function __construct($dbname, $username = "root", $password = "", $server = "localhost", $charset = "utf8mb4")
    {

        $conn = new mysqli($server, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->set_charset($charset);
        $this->db = $conn;

    }

    private function error($reason) {

        $errors = [
            "tableSet" => "The table does not set, use table() method to define table.",
            "whereArrayConflict" => "You can't use where method with whereArray method concurrently",
            "orWhereError" => "You can't use orWhere method without where or whereArray method.",
        ];

        if ($reason == 'plain') {

            return "Error: " . $this->db->error;

        }

        die("Error: " . $errors[$reason]);

    }

    private function errorHandle($method) {

        if ($method == "get") {

            if ($this->table == "") {

                $this->error("tableSet");

            }

        }

        if ($method == "orWhere") {

            if ($this->where !== "") {

                $this->error("orWhereError");

            }

        }

        if ($method == "whereArray") {

            if ($this->where !== "") {

                $this->error("whereArrayConflict");

            }

        }

    }



    /**
     * Get array and turn into object
     * @param array $array
     * @return object
     */
    private function turnIntoObject(array $array) {

        return json_decode(json_encode($array));

    }

    /**
     * Get query
     * @return mysqli_result
     */
    private function query()
    {
        $query = $this->query;

        return $this->db->query($query);

    }

    /**
     * Table
     * @param string $table <p>
     * The table.
     * </p>
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Where
     * @param string $column <p>
     * The column.
     * </p>
     * @param string $value <p>
     * The value or operator.
     * </p>
     * @param string $operator <p>
     * The value when operator have declare.
     * </p>
     * @return $this
     */
    public function where($column, $value, $operator = "=")
    {

        if ($this->where == "") {

            $this->where = "WHERE ";

        } else {

            $this->where .= " and ";

        }

        $this->where .= $column . " $operator " . $value;



        return $this;
    }


    /**
     * WhereArray
     * @param array $array <p>
     * Column and values inside an array.
     * </p>
     * @return $this
     */
    public function whereArray(array $array) {

        $this->errorHandle('whereArray');

        $this->where = "WHERE ";

        $count = count($array);
        $i = 1;
        foreach ($array as $key => $value) {

            $this->where .= $key . " = " . "'" . $value . "'";

            if ($i < $count) {
                $this->where .= " and ";
            }
            $i++;
        }

        return $this;

    }

    /**
     * Or where
     * @param string $column <p>
     * The column.
     * </p>
     * @param string $value <p>
     * The value.
     * </p>
     * @param string $operator <p>
     * The operator.
     * </p>
     * @return $this
     */
    public function orWhere($column, $value, $operator = "=") {

        $this->errorHandle('orWhere');

        $this->where .= " or ";


        $this->where .= $column . " $value " . $operator;

        return $this;

    }
    /**
     * Get all
     * @param string $cols <p>
     * The columns.
     * </p>
     * @param int $limit <p>
     * The limit of rows.
     * </p>
     * @return object
     */
    public function getAll($cols = "*", int $limit = 0)
    {

        $this->errorHandle("get");

        if ($limit !== 0) {
            $limit = "LIMIT $limit";
        } else {
            $limit = "";
        }

        $this->query = "SELECT $cols From $this->table $this->where $this->order $limit";

        return  $this->turnIntoObject($this->query()->fetch_all(MYSQLI_ASSOC));

    }

    /**
     * First
     * @param string $cols <p>
     * The columns.
     * </p>
     * @return object
     */
    public function first($cols = "*") {

        $this->errorHandle("get");

        $this->query = "SELECT $cols From $this->table $this->where $this->order";

        return $this->turnIntoObject($this->query()->fetch_assoc());
    }

    /**
     * Last
     * @param string $cols <p>
     * The columns.
     * </p>
     * @return object
     */
    public function last($cols = "*") {

        $this->errorHandle("get");

        $this->query = "SELECT $cols From $this->table $this->where $this->order";

        $query = $this->query()->fetch_all(MYSQLI_ASSOC);

        $count = count($query);

        return $this->turnIntoObject($query[$count - 1]);

    }

    /**
     * Last
     * @param string $by <p>
     * The column.
     * </p>
     * @param string $value <p>
     * Order kind.
     * </p>
     * @return $this
     */
    public function order($by, $value = "ASC") {

        $this->order = "ORDER BY $by $value";

        return $this;
    }


    /**
     * Insert
     * @param array $data
     * If was not successful:
     * @return string Error
     */
    public function insert(array $data) {

        $cols = "";
        $values = "";

        foreach ($data as $key => $value) {
            $cols .= "`" . $key . "`" . ",";
            $values .= "'" . $value . "'" . ",";
        }
        $cols = substr($cols, 0, -1);
        $values = substr($values, 0, -1);

        $this->query = "INSERT INTO $this->table ($cols) VALUES ($values)";

        if (!$this->query()) {

            return $this->error("plain");

        }

    }


    /**
     * Update
     * @param array $data
     * If was not successful:
     * @return string Error
     */
    public function update(array $data) {

        $out = "";

        foreach ($data as $key => $value) {
            $out = " `" . $key . "` = " . "'" . $value . "',";
        }
        $out = substr($out, 0, -1);

        $this->query = "UPDATE $this->table SET $out $this->where";

        if (!$this->query()) {

            return $this->error("plain");

        }

    }

    /**
     * Delete
     * If was not successful:
     * @return string Error
     */
    public function delete() {

        $query = "DELETE FROM $this->table $this->where";


        if (!$this->query($query)) {

            return $this->error("plain");

        }

    }

    /**
     * Create table
     * @param string $tableName
     * @param array $args
     * If was not successful:
     * @return string Error
     */
    public function createTable(string $tableName, array  $args) {

        $sql = "CREATE TABLE $tableName (";
        foreach ($args as $arg) {
            $sql .= $arg . ",";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ")";
        $this->query = $sql;

        if (!$this->query()) {

            return $this->error("plain");

        }

    }

    /**
     * Count of rows
     * @return int
     */
    public function countOfRows() {

        $this->query = "SELECT * From $this->table $this->where ";

        return $this->query()->num_rows;
    }

}