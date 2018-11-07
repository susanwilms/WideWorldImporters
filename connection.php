<?php
$servername = "localhost";
$username = "susan";
$password = "";
$dbname = "wideworldimporters";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmt = $conn->prepare("SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems;");
$stmt->execute();
$result = $stmt->fetchAll();

$conn = null;

?>