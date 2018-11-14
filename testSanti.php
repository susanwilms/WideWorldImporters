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
$nRows = $conn->query("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = $productgroup")->rowCount();
$aantalPages= $nRows/$limit;
print($nRows);
echo "<br>";
$aantalPages=ceil($aantalPages);
echo $aantalPages;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

</body>
</html>