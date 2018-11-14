<?php
/**
 * Created by PhpStorm.
 * User: susanwilms
 * Date: 13/11/2018
 * Time: 14:08
 */


require_once('header.php');
include ('connection.php');

$description = filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING);
?>
<p><?php print($description); ?></p>

<?php
$select = $conn->prepare('SELECT * FROM stockitems WHERE SearchDetails LIKE "%' . $description . '%"');

$select->execute();
$result = $select->fetchAll();

$productName =      $result[0]["StockItemName"];
$productPrice =     $result[0]["RecommendedRetailPrice"];

?>

<p><?php print($productName); ?></p> <br>
<p><?php print($productPrice); ?></p>
