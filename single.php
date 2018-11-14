<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$productid = $_GET['ProductID'];

require_once('header.php');
include ('connection.php');

$select = $conn->prepare("SELECT * FROM stockitems WHERE StockItemID = ${productid}");

$select->execute();
$result = $select->fetchAll();

$productName =      $result[0]["StockItemName"];
$productPrice =     $result[0]["RecommendedRetailPrice"];
$productTime =      $result[0]["LeadTimeDays"];
$productInStock =   2;
$productColorID =   $result[0]["ColorID"];

$color = $conn->prepare("SELECT * FROM colors WHERE ColorID = 1");

$color->execute();
$colorresult = $color->fetchAll();

$colorName =        $colorresult[0]["ColorName"];

?>

<div class="container col-md-12 pt-8" st>

    <div class="img col-md-6 left" id="product_img">
    </div>

    <div class="info col-md-6 pt-4 right" id="productinfo">
        <form action="cart.php" method="post">
            <input type="hidden" name="productID" value="<?php print($productid); ?>">

            <p><?php print($productName); ?></p>
            <p>Prijs: €<?php print($productPrice); ?></p>
            <p>Verwachte levertijd: <?php print($productTime); ?></p>
            <p><?php print($productInStock); ?> items op voorraad</p>
            <span class="dot" style="background-color: <?php echo $colorName; ?>;"></span><span>Kleur: <?php echo $colorName; ?></span><br>
            <label class="label-aantal">Aantal:</label><input class="number" type="number" name="Aantal" min="1" value="1">
            <input class="submitbutton" type="submit" name="verzenden" value="Voeg toe">
        </form>

        <div class="images">
            <div class="container">
                <div class="row blog">
                    <div class="col-md-12">
                        <div id="blogCarousel" class="carousel slide" data-ride="carousel">



                            <!-- Carousel items -->
                            <div class="carousel-inner">

                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-md-3 carouselitem">
                                            <a href="#">
                                                <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                            </a>
                                        </div>
                                        <div class="col-md-3 carouselitem">
                                            <a href="#">
                                                <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                            </a>
                                        </div>
                                        <div class="col-md-3 carouselitem">
                                            <a href="#">
                                                <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                            </a>
                                        </div>
                                        <div class="col-md-3 carouselitem">
                                            <a href="#">
                                                <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                            </a>
                                        </div>
                                    </div>
                                    <!--.row-->
                                </div>
                                <!--.item-->

                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-md-3 carouselitem">
                                            <a href="#">
                                                <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                            </a>
                                        </div>
                                        <div class="col-md-3 carouselitem">
                                            <a href="#">
                                                <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                            </a>
                                        </div>
                                        <div class="col-md-3 carouselitem">
                                            <a href="#">
                                                <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                            </a>
                                        </div>
                                        <div class="col-md-3 carouselitem">
                                            <a href="#">
                                                <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                            </a>
                                        </div>
                                    </div>
                                    <!--.row-->
                                </div>
                                <!--.item-->

                            </div>
                            <!--.carousel-inner-->
                            <ol class="carousel-indicators">
                                <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#blogCarousel" data-slide-to="1"></li>
                            </ol>
                        </div>
                        <!--.Carousel-->

                    </div>
                </div>
            </div>
        </div>

        <iframe class="videoplayer"
                src="https://www.youtube.com/embed/ixkoVwKQaJg">
        </iframe>


</div>
