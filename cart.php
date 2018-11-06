<?php

require_once './connection.php';
require_once './header.php';

// checked of er iets in de cart staat, als dat niet zo is wordt cart = 0.
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = 0;
}

$totaal = 0;

//session_destroy();


?>


    <div class="container pt-5 col-md-10">
        <h2 class="pt-5 pb-4">Je winkelmand</h2>

        <?php
        // als sessie niet 0 (dus er zitten items in de mand) zal de winkelmand weergegeven worden
        if($_SESSION['cart'] != 0) {
        print_r($_SESSION);
        //loopt door ieder item in de winkelmand sessie
        foreach ($_SESSION['cart'] as $id => $aantal) {
            // haalt underscores weg zodat de query werkt
            $id2 = substr($id, 1);
            ?>
            <div class="row py-2" style="">
                <div class="col-md-2">
                    <img src="https://www.bbqenzo.nl/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/d/r/drank-alcohol-vrij-bier.jpg" class="img-thumbnail" alt="Plaatje"
                         width="100" height="100">
                </div>

                <div class="col-md-6">
                    <!--    print de naam van het artikel   -->
                    <h5><?php echo $result[$id2]['StockItemName']?></h5>
                    <h6> Op voorraad.</h6>
                </div>

                <div class="col-md-2">
                    <!--    print het aantal van het artikel    -->
                    <h6 style="float:left">Aantal:</h6> <input class="aantal" type="number" min="1" value="<?php echo $_SESSION['cart'][$id]?>">
                </div>

                <div class="col-md-2">
                    <!--    print de prijs van het artikel   -->
                    <h6> € <?php echo $result[$id2]["RecommendedRetailPrice"]?> </h6>
                </div>

            </div>
            <?php
            // berekend het totaal van de winkelmand
            $totaal+= ($_SESSION['cart'][$id] * $result[$id2]["RecommendedRetailPrice"]);
        }

        ?>
            <!--    Afreken button en totaalprijs   -->
            <button style="float:right" type="submit" class="btn btn-primary">Afrekenen</button>
            <h4 style="float:right" class="col-md-2">Totaal: € <?php echo $totaal?> </h4>
            <?php
        }
        else {
            //wanneer ['cart'] dus 0 is is de winkelmand leeg
            echo 'Je winkelmand is leeg';
            echo '<br>';
            print_r($_SESSION);
            }
        ?>

    </div>


<?php
require_once './footer.php';
?>