<?php
require_once 'connection.php';
require_once 'header.php';



// QUERY 1, used for getting the customers information
$id=$_SESSION['id'];
$stmt = $conn->prepare("SELECT CustomerName, Email, PhoneNumber, Country, city, DeliveryAddressLine1, DeliveryPostalCode FROM customers WHERE CustomerID = $id;");
$stmt->execute();
$result2 = $stmt->fetch();
?>
    <link rel="stylesheet" href="myaccount.css">

    <nav class="navbar-primary">
        <a href="#" class="btn-expand-collapse"><span class="glyphicon glyphicon-menu-left"></span></a>
        <ul class="navbar-primary-menu">
            <li>
                <a class="activenav" href=""><span class="glyphicon glyphicon-list-alt"></span><span class="nav-label">Mijn Account</span></a>
                <a class="" href="orderhistory.php"><span class="glyphicon glyphicon-envelope"></span><span class="nav-label">Mijn bestellingen</span></a>
                <a href="destroy.php"><span class="glyphicon glyphicon-cog"></span><span id="destroy" class="nav-label">Uitloggen</span></a>
            </li>
        </ul>
    </nav>
    <div class="main-content">
        <h1> Mijn gegevens</h1>
        <div class="col-md-6">
            <!-- TODO: use real information from session/database -->
            <h6>Naam</h6>
            <?php
            echo $result2["CustomerName"];
            ?>
            <br>
            <br>
            <h6>E-mail adres</h6>
            <?php
            echo $result2["Email"];
            ?>
            <br>
            <br>
            <h6>Telefoonnummer</h6>
            <?php
            echo $result2["PhoneNumber"];
            ?>
            <br>
            <br>
            <h6>Adres</h6>
            <?php
            echo $result2["DeliveryAddressLine1"];
            ?>
            <br>
            <?php
            echo $result2["DeliveryPostalCode"];
            ?>
            <br>
            <br>
            <h6>Woonplaats</h6>
            <?php
            echo $result2["city"];
            ?>
        </div>
    </div>



<?php
require_once 'footer.php';
?>