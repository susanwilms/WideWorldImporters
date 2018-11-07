<?php

require_once './connection.php';
require_once './header.php';


// checked of er iets in de cart staat, als dat niet zo is wordt cart = 0.
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = 0;
}


$totaal = 0;


// checked of verwijder een value heeft en dus een artikel gedelete moet worden
if (filter_has_var(INPUT_POST, "verwijder")) {
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $verwijder = filter_input(INPUT_POST, "verwijder", FILTER_SANITIZE_STRING);

    // checked of het product in de mand zit, als dat zo is, verwijder het
    if (isset($_SESSION['cart'][$post_id])) {
        unset($_SESSION['cart'][$post_id]);
    }

    // checked of er nog meer artikelen in de mand zitten of niet
    if (count($_SESSION['cart']) == 0) {
        // als er niks meer in de mand zit, mag de hele mand sessie weg, en op 0 gezet worden
        unset($_SESSION['cart']);
        $_SESSION['cart'] = 0;
    }
}


// checked of verlaag een value heeft, en er dus een artikel in aantal verlaagd moet worden
if (filter_has_var(INPUT_POST, "verlaag")) {
    // haalt het id uit het hidden veld
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $verlaag = filter_input(INPUT_POST, "verlaag", FILTER_SANITIZE_STRING);

    // als het aantal al 1 is, moet het niet lager, maar moet het hele artikel uit de mand
    if ($_SESSION['cart'][$post_id] == 1) {
        // unset het artikel zodat het uit de mand is
        unset($_SESSION['cart'][$post_id]);

        // checked of er nog meer artikelen in de mand zitten of niet
        if (count($_SESSION['cart']) == 0) {
            // als er niks meer in de mand zit, mag de hele mand sessie weg, en op 0 gezet worden
            unset($_SESSION['cart']);
            $_SESSION['cart'] = 0;
        }

    } elseif (isset($_SESSION['cart'][$post_id])) {
        if ($_SESSION['cart'][$post_id] > 1)
        // anders gaat het aantal gewoon 1 omlaag
        $_SESSION['cart'][$post_id]--;
    }

}


// checked of verhoog een value heeft, en er dus een artikel in aantal verhoogd moet worden
if (filter_has_var(INPUT_POST, "verhoog")) {
    // haalt het id uit het hidden veld
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $verhoog = filter_input(INPUT_POST, "verhoog", FILTER_SANITIZE_STRING);

    // verhoogd het artikel met $post_id met 1
    $_SESSION['cart'][$post_id]++;
}


// haalt dingen uit post van productpagina en zet het in cart array
if (filter_has_var(INPUT_POST, "productID")) {
    $ProductID = filter_input(INPUT_POST, "productID", FILTER_SANITIZE_STRING);
    // hoe veel er toegevoegd moet worden
    $add_aantal = filter_input(INPUT_POST, "Aantal", FILTER_SANITIZE_STRING);

    // als cart eerst leeg was, unset cart
    if ($_SESSION['cart'] == 0) {
        unset($_SESSION['cart']);
    }
    // als er nog niet al een product met zelfde is is, set aantal op doorgegeven aantal
    if (!isset($_SESSION['cart']['_' . $ProductID])) {
        $_SESSION['cart']['_' . $ProductID] = $add_aantal;
        //als dat er al wel is, tel bestaande aantal op bij nieuwe aantal
    } elseif (isset($_SESSION['cart']['_' . $ProductID])) {
        $_SESSION['cart']['_' . $ProductID]+= $add_aantal;
    }
}

?>

    <div class="container pt-5 col-md-8">
        <h2 class="pt-5 pb-4">Je winkelmand</h2>

        <?php
        // als sessie niet 0 (dus er zitten items in de mand) zal de winkelmand weergegeven worden
        if($_SESSION['cart'] != 0) {

            //loopt door ieder item in de winkelmand sessie
            foreach ($_SESSION['cart'] as $id => $aantal) {
                // haalt underscores weg zodat de query werkt
                $id2 = substr($id, 1);
                ?>

                <div class="row py-2">
                    <div class="col-md-1">
                        <img src="https://www.bbqenzo.nl/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/d/r/drank-alcohol-vrij-bier.jpg" class="img-thumbnail" alt="Plaatje" width="100" height="100">
                    </div>

                    <div class="col-md-6">
                        <!--    print de naam van het artikel   -->
                        <h5 class="plaatje"><?php echo $result[$id2 - 1]['StockItemName']?></h5>
                        <h6> Op voorraad.</h6>
                    </div>

                    <div class="col-md-4">

                        <h6 class="aantal" style="float:left">Aantal:</h6>

                        <div class="col-md-12">
                            <!--    print het aantal van het artikel    -->
                            <input class="form-control col-md-3 aantalproducten" type="number" min="1" value="<?php echo $_SESSION['cart'][$id]?>">


                                <!--    deleten uit cart   -->
                                <form method="post" action=""  class="form-delete-button">
                                    <!--    stuurt een hidden veld mee met het id van het product dat verwijderd moet worden-->
                                    <input name="post_id" type="hidden" value="<?php echo $id?>">
                                    <button type="submit" name="verwijder" value="1" class="btn btn-secondary">x</button>
                                </form>

                                <!--    verlagen van aantal      -->
                                <form method="post" action="" class="form-button">
                                    <!--    stuurt een hidden veld mee met het id van het product dat verlaagd moet worden-->
                                    <input name="post_id" type="hidden" value="<?php echo $id?>">
                                    <button type="submit" name="verlaag" value="1" class="btn btn-secondary">-</button>
                                </form>

                                <!--    verhogen van aantal     -->
                                <form method="post" action="" class="form-button">
                                    <!--    stuurt een hidden veld mee met het id van het product dat verhoogd moet worden-->
                                    <input name="post_id" type="hidden" value="<?php echo $id?>">
                                    <button type="submit" name="verhoog" value="1" class="btn btn-secondary">+</button>
                                </form>


                        </div>

                    </div>

                    <div class="col-md-1">
                        <!--    print de prijs van het artikel   -->
                        <h6> € <?php echo $result[$id2 - 1]["RecommendedRetailPrice"]?> </h6>
                    </div>


                </div>
                <?php
                // berekend het totaal van de winkelmand
                $totaal+= ($_SESSION['cart'][$id] * $result[$id2 - 1]["RecommendedRetailPrice"]);
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

            }
        ?>

    </div>


<?php
require_once './footer.php';
?>