<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

// Get product ID from the product overview page
$productid = filter_input(INPUT_GET, "ProductID", FILTER_SANITIZE_STRING);

// Require header and connection
require_once('header.php');
include ('connection.php');

// Select query -> product information where StockItemID = $productID
$select = $conn->prepare("SELECT * FROM stockitems WHERE StockItemID = :productid");
// Set :productid = $productid
$select->bindParam(':productid', $productid);
$select->execute();
$result = $select->fetchAll();

// Set the variables with the results I need
$productName =      $result[0]["StockItemName"];
$productPrice =     $result[0]["RecommendedRetailPrice"];
$productTime =      $result[0]["LeadTimeDays"];
$productDescription = $result[0]["MarketingComments"];
$productColorID =   $result[0]["ColorID"];

// Select query to get the color information from the color table
$color = $conn->prepare("SELECT * FROM colors WHERE ColorID = 1");
$color->bindParam(':colorid', $productColorID);
$color->execute();
$colorresult = $color->fetchAll();

// Set the $colorname variable with the color I need
$colorName =        $colorresult[0]["ColorName"];

// Select query to get the paths of the images from the single product
$images = $conn->prepare("SELECT * FROM img_path WHERE productID = " . $productid);
$images->execute();
$imagesResult = $images->fetchAll();

// Select query to get the numbers of items in stock for this single product
$stmt2 = $conn->prepare("SELECT StockItemID, QuantityOnHand FROM stockitemholdings WHERE StockItemID = :productid");
$stmt2->bindParam(':productid', $productid);
$stmt2->execute();
$stock_query = $stmt2->fetchAll();

// Set the variable with the number of items in stock
$productQuantityInStock = $stock_query[0]["QuantityOnHand"];




?>

<div class="container col-md-12 pt-8">

    <!-- Big product image -->
    <div class="img col-md-6 left" id="product_img">
    </div>

    <!-- Product info on the right side of the page -->
    <div class="info col-md-6 pt-4 right" id="productinfo">
        <form action="cart.php" method="post">
            <!-- Hidden field with the product ID to send with the form -->
            <input type="hidden" name="productID" value="<?php print($productid); ?>">

            <p><?php print($productName); ?></p>
            <p><?php print($productDescription);?></p>
            <p>Prijs: €<?php print($productPrice); ?></p>
            <p>Verwachte levertijd: <?php print($productTime); ?></p>
            <p><?php echo $productQuantityInStock; ?> items op voorraad</p>
            <span class="dot" style="background-color: <?php echo $colorName; ?>;"></span><span>Kleur: <?php echo $colorName; ?></span><br>
            <label class="label-aantal">Aantal:</label><input class="number" type="number" name="Aantal" min="1" max="100" value="1">
            <input class="submitbutton" type="submit" name="verzenden" value="Voeg toe">
        </form>
         <!-- Small images which are clickable -->
        <div class="images">
            <div class="col-sm-12">
                <?php
                    // Foreach which gets all the image paths from the database
                    foreach($imagesResult as $number => $array){
                        $path = $array["img_path"];
                        $id = $array["pathID"];
                        ?>
                        <img class="small-img" onclick="imgFunction('<?php echo $path?>')" id="image- <?php echo $id?>" src=".<?php echo $path?>">
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Iframe with the videoplayer -->
        <iframe class="videoplayer"
                src="https://www.youtube.com/embed/ixkoVwKQaJg">
        </iframe>


</div>

<script>
    // Javascript function to make the small images clickable

    function imgFunction(path) {
        document.getElementById("product_img").style.backgroundImage = "url('." + path + "')";
    }
    window.onload = imgFunction('/images/<?php echo $productid?>-1.jpg');
</script>

<?php
    require_once ('footer.php');
?>




