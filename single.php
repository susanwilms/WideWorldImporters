<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$productid = filter_input(INPUT_GET, "ProductID", FILTER_SANITIZE_STRING);

require_once('header.php');
include ('connection.php');

$select = $conn->prepare("SELECT * FROM stockitems WHERE StockItemID = :productid");
$select->bindParam(':productid', $productid);
$select->execute();
$result = $select->fetchAll();

$productName =      $result[0]["StockItemName"];
$productPrice =     $result[0]["UnitPrice"];
$productTime =      $result[0]["LeadTimeDays"];
$productInStock =   2;
$productColorID =   $result[0]["ColorID"];

$color = $conn->prepare("SELECT * FROM colors WHERE ColorID = 1");

$color->execute();
$colorresult = $color->fetchAll();

$colorName =        $colorresult[0]["ColorName"];

$images = $conn->prepare("SELECT * FROM img_path WHERE productID = " . $productid);
$images->execute();
$imagesresult = $images->fetchAll();



?>

<div class="container col-md-12 pt-8">

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
            <label class="label-aantal">Aantal:</label><input class="number" type="number" name="Aantal" min="1" max="100" value="1">
            <input class="submitbutton" type="submit" name="verzenden" value="Voeg toe">
        </form>

        <div class="images">
            <div class="container">
                <div class="row blog">
                    <div class="col-sm-12">
                        <?php
                        foreach($imagesresult as $number => $imginfo){
                            $imgpath = $imgresult[$number]["img_path"];
                            echo"<img src='" . $imgpath . "'>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <iframe class="videoplayer"
                src="https://www.youtube.com/embed/ixkoVwKQaJg">
        </iframe>


</div>
