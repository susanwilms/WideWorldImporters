<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wideworldimporters";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

session_start();
session_destroy();

header("location: index.php");