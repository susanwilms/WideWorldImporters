<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wideworldimporters";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmt = $conn->prepare("SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems;");
$stmt->execute();
$result = $stmt->fetchAll();
print_r($result);
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wide World Importers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="shadow-m navbar navbar-expand-sm bg-light navbar-light fixed-top">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="/">WWI</a>
    <a href="/"><i class="pr-5 fas fa-home fa-lg"></i></a>

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown px-5">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Categorieën
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">categorie 1</a>
                <a class="dropdown-item" href="#">categorie 2</a>
                <a class="dropdown-item" href="#">categorie 3</a>
            </div>
        </li>
        <!--        <li class="nav-item">-->
        <!--        <form class="form-inline px-5" action="/action_page.php">-->
        <!--            <div class="input-group input-group-sm">-->
        <!--                <input type="text" name="search" class="form-control">-->
        <!--            </div>-->
        <!--            <div class="input-group-append">-->
        <!--                <button class="btn-sm btn-secondary" type="submit">Zoeken</button>-->
        <!--            </div>-->
        <!--        </form>-->
        <!--        </li>-->

    </ul>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="/cart"><i class="px-3 fas fa-shopping-cart fa-lg"></i></a>
        </li>
        <li class="nav-item">
            <i class="px-3 fas fa-user fa-lg"></i>
        </li>

    </ul>
</nav>

<div class="container pt-4">
    <div class="row">
        <?php
        foreach($result as $r){
            $stock_id = $r[0];
            $stock_name = $r[1];
            $stock_price = $r[2];
            ?>
            <div class="col-md-4 pb-2">
                <div class="card mb-4 text-center" style="background-color:rgb(155, 155, 155);">
                    <div class="card-body text-center text-white">
                        <p class="text-left card-text"><span style="float:right;"><?php echo $stock_name; ?></span></p>
                        <p class="text-left card-text">Prijs:<span style="float:right;"><?php echo $stock_price; ?></span></p>
                    </div>
                    <a href="images/placeholder.png">
                        <img class="card-img" src="images/placeholder.png" alt="<?php echo $stock_name; ?>">
                    </a>
                    <!--                    <div class="card-body text-center text-white py-2">-->
                    <!--                        <a href="https://t45.nl/3/--><?php //echo $img_name; ?><!--.png" class="btn btn-dark">View Image</a>-->
                    <!--                    </div>-->
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>

