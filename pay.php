<?php

require_once 'connection.php';

$fullName = filter_input(INPUT_POST, "fullName", FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
$postcode = filter_input(INPUT_POST, "postcode", FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
$land = "Nederland";
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$phoneNumber= filter_input(INPUT_POST, "phoneNumber", FILTER_SANITIZE_STRING);

$name= explode(" ", $fullName);
$addressing= explode(" ", $address);

if(empty(!$_POST)) {
    echo "Firstname is: $name[0]<br>";
    echo "Lastname is: $name[1]<br>";
    echo "Straat is: $addressing[0]<br>";
    echo "Huisnummer is: $addressing[1]<br>";
    echo "Stad is: $city<br>";
    echo "Land is: $land<br>";
    echo "Email is: $email<br>";
    echo "Telefoon number: $phoneNumber<br>";

}

//$stmtInsert= $conn->prepare(INSERT INTO customers ())


?>


<html>
<body style="background-color:#eef0f0;">
<div style="width: 100%; text-align: center;">

    <?php
    if(empty($_POST)) {
        ?>
        <a href="/WideWorldImporters/order_confirm.php"><img src="./images/checkout.png" alt="iDEALpage" align="middle" height="597" width="770"/></a>
        <?php
    }
    ?>
    </div>
</body>
</html>