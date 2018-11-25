<?php

require_once "connection.php";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// empty the img_path table
$truncate = "TRUNCATE ${dbname}.img_path";
$conn->exec($truncate);
echo("img_path tabel succesvol geleegd<br>");

$path    = "./images/";
$files = scandir($path);
// excluding non product images
$files = array_diff(scandir($path), array(".", "..", "cart.png", "cart_icon.png", "favicon-32x32.png", "favicon-16x16.png", "favicon.ico", "header.jpg", "PicProduct1.png", "pay.png", "logo.png", "placeholder.png", "productgroup1.jpg", "productgroup2.jpg", "productgroup3.jpg", "productgroup4.jpg", "productgroup5.jpg", "productgroup6.jpg", "productgroup7.jpg", "productgroup8.jpg", "productgroup9.jpg", "productgroup10.jpg", "top_placeholder.png"));
// pretty printing
echo "<pre>"; print_r($files); echo "</pre>";

// loop through each file and add it to the db
foreach($files as $file){
    $arr = explode("-", $file, 2);
    $img_id = $arr[0];

    echo("Foto " . $file . ": ");
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $file = "/images/" . $file;
    $sql = "INSERT INTO img_path (ProductID, img_path)
    VALUES (${img_id}, '${file}')";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Record succesvol aangemaakt <br>";
}
