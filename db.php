<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'recipes_db';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed" . $conn->connect_error);
}
?>
