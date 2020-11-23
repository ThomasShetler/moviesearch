<?php
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "moviedb";

$db = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>