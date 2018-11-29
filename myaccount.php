<?php
require_once 'connection.php';
require_once 'header.php';



// QUERY 1, used for getting the customers information
$id=$_SESSION['id'];
$stmt = $conn->prepare("SELECT CustomerName, Email, PhoneNumber, Country, city, DeliveryAddressLine1, DeliveryPostalCode FROM customers WHERE CustomerID = $id;");
$stmt->execute();
$result2 = $stmt->fetch();
?>
<style>

    .navbar-primary {
        background-color: #F8F9FA;
        bottom: 0px;
        left: 0px;
        position: fixed;
        top: 60px;
        width: 200px;
        z-index: 8;
        overflow: hidden;
        -webkit-transition: all 0.1s ease-in-out;
        -moz-transition: all 0.1s ease-in-out;
        transition: all 0.1s ease-in-out;
    }

    .navbar-primary.collapsed {
        width: 60px;
    }

    .navbar-primary.collapsed .glyphicon {
        font-size: 22px;
    }

    .navbar-primary.collapsed .nav-label {
        display: none;
    }

    .btn-expand-collapse:hover,
    .btn-expand-collapse:focus {
        background-color: #222;
        color: white;
    }

    .btn-expand-collapse:active {
        background-color: #111;
    }

    .navbar-primary-menu,
    .navbar-primary-menu li {
        margin:0; padding:0;
        list-style: none;
    }

    .navbar-primary-menu li a {
        display: block;
        padding: 10px 18px;
        text-align: left;
        /*border-bottom:solid 1px #444;*/
        color: #ccc;
    }

    .navbar-primary-menu li a:hover {
        background-color: #06bcf2;
        text-decoration: none;
        color: white;
    }

    .navbar-primary-menu li a .glyphicon {
        margin-right: 6px;
    }

    .navbar-primary-menu li a:hover .glyphicon {
        color: orchid;
    }

    .main-content {
        margin-top: 60px;
        margin-left: 200px;
        padding: 20px;
    }

    .collapsed + .main-content {
        margin-left: 60px;
    }
    .nav-label{
        color: rgba(0,0,0,.5);
    }
    .activenav{
        background-color: #06bcf2;
    }

</style>

    <nav class="navbar-primary">
        <a href="#" class="btn-expand-collapse"><span class="glyphicon glyphicon-menu-left"></span></a>
        <ul class="navbar-primary-menu">
            <li>
                <a class="activenav" href=""><span class="glyphicon glyphicon-list-alt"></span><span class="nav-label">Mijn Account</span></a>
                <a class="" href="orderhistory.php"><span class="glyphicon glyphicon-envelope"></span><span class="nav-label">Mijn bestellingen</span></a>
                <a class="" href="addressinfo.php"><span class="glyphicon glyphicon-cog"></span><span class="nav-label">Adresgegevens wijzigen</span></a>
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