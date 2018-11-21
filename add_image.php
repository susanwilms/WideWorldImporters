<?php

require_once 'connection.php';

$path    = './images/';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..', 'header.jpg', 'PicProduct1.png', 'afrekenen.png', 'iDEAL_ss.PNG', 'logo.png', 'placeholder.png', 'productgroup1.jpg', 'productgroup2.jpg', 'productgroup3.jpg', 'productgroup4.jpg', 'productgroup5.jpg', 'productgroup6.jpg', 'productgroup7.jpg', 'productgroup8.jpg', 'productgroup9.jpg', 'productgroup10.jpg', 'top_placeholder.png'));
print_r($files);

foreach($files as $file){
    $arr = explode("-", $file, 2);
    $img_id = $arr[0];

    print($img_id . '<br>');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $file = '/images/' . $file;
    $sql = "INSERT INTO img_path (ProductID, img_path)
    VALUES (${img_id}, '${file}')";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "New record created successfully <br>";
}
