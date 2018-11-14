<?php session_start();

$productgroup="";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wide World Importers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./includes/default.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="shadow navbar navbar-expand-sm bg-light navbar-light fixed-top">
    <!-- Brand/logo -->

    <a href="/WideWorldImporters/index.php" id="logo"><img id="logo-img" src="images/logo.png"></a>

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown px-5">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Categorieën
            </a>
            <div class="dropdown-menu">
                <?php
                $categorien = array("Novelty Items","Clothing","Mugs","T-Shirs","Airline Novelties","Computing Novelties","USB Novelties","Furry Footwear","Toys","Packaging Materials");
                $productgroup=0;

                for($i=0;$i<count($categorien);$i++){
                    $productgroup++;
                ?>
                <a class="dropdown-item" href="<?php print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>"><?php print($categorien[$i])?></a>
                <?php
                }
                ?>
            </div>
        </li>

        <a class="navbar-brand" id="brand" href="/WideWorldImporters/index.php">Wide World Importers</a>
<!--                <li class="nav-item">-->
<!--                <form class="form-inline px-5" action="/action_page.php">-->
<!--                    <div class="input-group input-group-sm">-->
<!--                        <input type="text" name="search" class="form-control">-->
<!--                    </div>-->
<!--                    <div class="input-group-append">-->
<!--                        <button class="btn-sm btn-secondary" type="submit">Zoeken</button>-->
<!--                    </div>-->
<!--                </form>-->
<!--                </li>-->

    </ul>
    <ul class="navbar-nav">
        <div class="searchbox">
            <form action="action_page.php" method="post">
                <input type="text" placeholder="Search.." name="search">
                <input type="submit" name="verstuur" value="zoek">
            </form>
        </div>

        <li class="nav-item">
            <a href="/WideWorldImporters/cart.php"><i class="px-3 fas fa-shopping-cart fa-lg"></i></a>

        </li>
        <li class="nav-item">
            <i class="px-3 fas fa-user fa-lg"></i>
        </li>

    </ul>
</nav>