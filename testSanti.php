<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wideworldimporters";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmtcat1= $conn->prepare("SELECT * FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE sto ");
$stmtcat1->execute();
$number_of_rows = $stmtcat1->rowCount();

$limit=24;
$productgroup=10;

session_destroy();

echo "destroy";