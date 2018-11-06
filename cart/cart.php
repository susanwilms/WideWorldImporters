<?php

require_once '../connection.php';
require_once '../header.php';


if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = 0;
}


$totaal = 0;

//session_destroy();


?>


    <div class="container pt-5 col-md-10">
        <h2 class="pt-5 pb-4">Je winkelmand</h2>

        <?php
        if(!$_SESSION['cart'] == 0) {
        print_r($_SESSION);
        foreach ($_SESSION['cart'] as $id => $aantal) {
            $id2 = substr($id, 1);
            ?>
            <div class="row py-2" style="">
                <div class="col-md-2">
                    <img src="https://www.bbqenzo.nl/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/d/r/drank-alcohol-vrij-bier.jpg" class="img-thumbnail" alt="Plaatje"
                         width="100" height="100">
                </div>
                <div class="col-md-6">
                    <h5><?php echo $result[$id2]['StockItemName']?></h5>
                    <h6> Op voorraad.</h6>

                </div>
                <div class="col-md-2">
                    <h6 style="float:left">Aantal:</h6> <input type="number" min="1" value="<?php echo $_SESSION['cart'][$id]?>">
                </div>
                <div class="col-md-2">
                    <h6> € <?php echo $result[$id2]["RecommendedRetailPrice"]?> </h6>
                </div>

            </div>
            <?php
            $totaal+= ($_SESSION['cart'][$id] * $result[$id2]["RecommendedRetailPrice"]);
        }

        ?>
            <!--    Afreken button en totaalprijs   -->
            <button style="float:right" type="submit" class="btn btn-primary">Afrekenen</button>
            <h4 style="float:right" class="col-md-2">Totaal: € <?php echo $totaal?> </h4>
            <?php
        }
        else {
            echo 'Je winkelmand is leeg';
            echo '<br>';
            print_r($_SESSION);
            }
        ?>


    </div>


<?php
require_once '../footer.php';
?>