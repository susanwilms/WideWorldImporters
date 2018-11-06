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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="shadow navbar navbar-expand-sm bg-light navbar-light fixed-top">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="/WideWorldImporters/index.php">WWI</a>
    <a href="/WideWorldImporters/index.php"><i class="pr-5 fas fa-home fa-lg"></i></a>

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown px-5">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Categorieën
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?php $productgroup=1; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">Novelty Items</a>
                <a class="dropdown-item" href="<?php $productgroup=2; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">Clothing</a>
                <a class="dropdown-item" href="<?php $productgroup=3; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">Mugs</a>
                <a class="dropdown-item" href="<?php $productgroup=4; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">T-Shirs</a>
                <a class="dropdown-item" href="<?php $productgroup=5; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">Airline Novelties</a>
                <a class="dropdown-item" href="<?php $productgroup=6; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">Computing Novelties</a>
                <a class="dropdown-item" href="<?php $productgroup=7; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">USB Novelties</a>
                <a class="dropdown-item" href="<?php $productgroup=8; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">Furry Footwear</a>
                <a class="dropdown-item" href="<?php $productgroup=9; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">Toys</a>
                <a class="dropdown-item" href="<?php $productgroup=10; print("/WideWorldImporters/Categories.php?Productgroup=".$productgroup); ?>">Packaging Materials</a>
            </div>
        </li>
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
        <li class="nav-item">
            <a href="/WideWorldImporters/cart.php"><i class="px-3 fas fa-shopping-cart fa-lg"></i></a>
        </li>
        <li class="nav-item">
            <i class="px-3 fas fa-user fa-lg"></i>
        </li>

    </ul>
</nav>