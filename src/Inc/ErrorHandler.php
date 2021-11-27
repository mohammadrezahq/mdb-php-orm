<?php

namespace Mor\Mdb\Inc;

trait ErrorHandler {

    protected function error($reason) 
    {

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

    protected function errorHandle($method) {

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
}