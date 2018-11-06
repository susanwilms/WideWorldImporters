<?php

require_once '../connection.php';
require_once '../header.php';


$totaal = 0;




?>

    <div class="container pt-5 col-md-10">
        <h2 class="py-3">Je winkelmand</h2>

        <?php
        foreach ($_SESSION as $id => $aantal) {
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
                    <h6 style="float:left"> Aantal:</h6> <input class="aantal" type="number" value="<?php echo $_SESSION[$id]?>">
                </div>
                <div class="col-md-2">
                    <h6> € <?php echo $result[$id2]["RecommendedRetailPrice"]?> </h6>
                </div>

            </div>
            <?php
            $totaal+= ($_SESSION[$id] * $result[$id2]["RecommendedRetailPrice"]);
        }
        ?>

        <button style="float:right" type="submit" class="btn btn-primary">Afrekenen</button>
        <h4 style="float:right" class="col-md-2">Totaal: <?php echo $totaal?> </h4>

    </div>


<?php
require_once '../footer.php';
?>