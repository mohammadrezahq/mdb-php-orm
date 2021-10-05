<?php
require_once ('msql.php');

$dbname = "users";
$username = "root";
$password = "";
$servername = "localhost";
$charset = "utf8mb4";

$msql = new Msql($dbname, $username, $password, $servername, $charset);

