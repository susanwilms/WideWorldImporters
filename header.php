<?php session_start();
$productgroup="";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wide World Importers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="/WideWorldImporters/images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/WideWorldImporters/images/favicon-16x16.png" sizes="16x16" />

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">

    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
        <a class="navbar-brand" href="/WideWorldImporters/index.php"><img class="logo" src="images/logo.png"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/WideWorldImporters/index.php" id="logo">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/WideWorldImporters/about.php">Over ons</a></li>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/WideWorldImporters/contact.php">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categorieën
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $categories = array("Novelty Items","Clothing","Mugs","T-Shirts","Airline Novelties","Computing Novelties","USB Novelties","Furry Footwear","Toys","Packaging Materials");
                        $productgroup=0;

                        for($i=0;$i<count($categories);$i++){
                            $productgroup++;
                            ?>
                            <a class="dropdown-item" href="<?php print("/WideWorldImporters/Categories.php?productgroup=".$productgroup); ?>"><?php print($categories[$i])?></a>
                            <?php
                        }
                        ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link account-item" href="/WideWorldImporters/<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && ){echo "myaccount.php";}else{echo "login.php";}?>">Account</a></li>
                </li>
            </ul>

            <form action="action_page.php" method="GET" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2 search-control" type="search" placeholder="Zoek..." name="search" aria-label="Search" required>
                <button class="btn my-2 my-sm-0 search-btn" type="submit"><i class="fa fa-search"></i></button>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="cart.php"><img class="shoppingcart_icon" src="images/cart_icon.png"></a>
                </li>
            </ul>

        </div>
    </nav>
</head>
<body style="margin-top:61px;margin-bottom: 120px;"">
