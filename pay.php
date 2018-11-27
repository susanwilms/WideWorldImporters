<?php

require_once 'connection.php';

$fullName = filter_input(INPUT_POST, "fullName", FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
$postcode = filter_input(INPUT_POST, "postcode", FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
$country = "Netherlands";
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$phoneNumber= filter_input(INPUT_POST, "phoneNumber", FILTER_SANITIZE_STRING);




if(empty(!$_POST)) {
    echo "Volledige naam is: $fullName<br>";
    echo "Adres is: $address<br>";
    echo "Postcode is: $postcode<br>";
    echo "Stad is: $city<br>";
    echo "Land is: $country<br>";
    echo "Email is: $email<br>";
    echo "Telefoon number: $phoneNumber<br>";




$stmtInsert= $conn->prepare('INSERT INTO customers (CustomerID, CustomerName,BillToCustomerID,CustomerCategoryID,PrimaryContactPersonID,
    DeliveryMethodID,DeliveryCityID,PostalCityID,AccountOpenedDate,StandardDiscountPercentage,IsStatementSent,
    IsOnCreditHold,PaymentDays,Email,PhoneNumber,FaxNumber,WebsiteURL,Country, City, DeliveryAddressLine1,DeliveryPostalCode,PostalAddressLine1,PostalPostalCode,
    LastEditedby,ValidFrom,ValidTo) SELECT MAX(customerID)+1, :name, max(customerid)+1, 0, 1, 1, 38187, 38187, now(),
0,0,0,7,:email,:phoneNumber,"Unknown","Unknown",:country,:city,:address,:postcode,"No PO BOX",:postcode,1, now(), "9999-12-31 23:59:59" FROM customers');

$stmtInsert->execute(array(':name' => $fullName,':email' => $email, ':phoneNumber' => $phoneNumber,
                      ':country' => $country,':city' => $city,':address' => $address,':postcode' => $postcode));

$conn=NULL;



}

?>


<style>
    body {
        background-color: #eef0f0;
    }
</style>
<div style="width: 100%; text-align: center;">
    <?php
    if(empty($_POST)) {
        ?>
        <a href="/WideWorldImporters/order_confirm.php"><img src="./images/pay.png" alt="iDEALpage" align="middle" height="597" width="770"/></a>
        <?php
    }
    ?>
</div>
