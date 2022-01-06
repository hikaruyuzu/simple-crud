<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "animelist";

$conn = mysqli_connect($host, $user, $password, $db);

// cek connection
if (!$conn) {
    die("Can't connect to database");
}
