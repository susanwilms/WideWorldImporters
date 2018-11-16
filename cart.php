<?php

require_once './connection.php';
require_once './header.php';

// SQL query used for id, name, price
$stmt = $conn->prepare("SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems;");
$stmt->execute();
$result = $stmt->fetchAll();

// checks if there is something in the cart. if not, cart = 0.
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = 0;
}


$totaal = 0;


// checks if delete has a value and if there's an article that has to be deleted
if (filter_has_var(INPUT_POST, "verwijder")) {
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $verwijder = filter_input(INPUT_POST, "verwijder", FILTER_SANITIZE_STRING);

    // checks if there's a product in the cart, if so, it deletes the product from the cart
    if (isset($_SESSION['cart'][$post_id])) {
        unset($_SESSION['cart'][$post_id]);
    }

    // checks if there are any more products in the cart
    if (count($_SESSION['cart']) == 0) {
        // if there's nothing left in the cart, it deletes the whole session and sets it to 0
        unset($_SESSION['cart']);
        $_SESSION['cart'] = 0;
    }
}


// checks if lower has a value and if there is a product that needs to be lowered in amount
if (filter_has_var(INPUT_POST, "verlaag")) {
    // haalt het id uit het hidden veld
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $verlaag = filter_input(INPUT_POST, "verlaag", FILTER_SANITIZE_STRING);

    // if the amount is already 1, it doesn't lower the amount but it removes the product from the cart instead
    if ($_SESSION['cart'][$post_id] == 1) {
        // unset the product so it's removed from the cart
        unset($_SESSION['cart'][$post_id]);

        // checks if there are any other products in the cart
        if (count($_SESSION['cart']) == 0) {
            // if there's nothing left in the cart, it deletes the whole session and sets it to 0
            unset($_SESSION['cart']);
            $_SESSION['cart'] = 0;
        }

    } elseif (isset($_SESSION['cart'][$post_id])) {
        if ($_SESSION['cart'][$post_id] > 1)
        // anders gaat het aantal gewoon 1 omlaag
        $_SESSION['cart'][$post_id]--;
    }

}


// checks if raise has a value and if there is a product that needs raising in amount
if (filter_has_var(INPUT_POST, "verhoog")) {
    // takes the id from the hidden field
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $verhoog = filter_input(INPUT_POST, "verhoog", FILTER_SANITIZE_STRING);

    if ($_SESSION['cart'][$post_id] >= 100) {
        // cant go higher than 100 so does nothing
        ?>

        <div class="container col-sm-8">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Sorry,</strong> je kan maximaal 100 stuks van een artikel tegelijk bestellen.
            </div>
        </div>


        <?php
        // TODO: melding over aantal hoger dan 100
    } else {
        // raises the product with $post_id with 1
        $_SESSION['cart'][$post_id]++;
    }

}


// checks if change has a value and if there is a product that needs changing
if (filter_has_var(INPUT_POST, "verander")) {
    // haalt het id uit het hidden veld
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $verander = filter_input(INPUT_POST, "verander", FILTER_SANITIZE_STRING);

    // the added number has to be 100 or less at all times
    if ($verander > 100) {
        $verander = 100;
    }

    // raises the product with $post_id with 1
    $_SESSION['cart'][$post_id] = $verander;
}


// haalt dingen uit post van productpagina en zet het in cart array
if (filter_has_var(INPUT_POST, "productID")) {
    $ProductID = filter_input(INPUT_POST, "productID", FILTER_SANITIZE_STRING);
    // hoe veel er toegevoegd moet worden
    $add_aantal = filter_input(INPUT_POST, "Aantal", FILTER_SANITIZE_STRING);

    // the added amount needs to be 1 or higher at all times
    if ($add_aantal < 1) {
        $add_aantal = 1;
    }

    // the added amount needs to be 100 or less at all times
    if ($add_aantal > 100) {
        $add_aantal = 100;
    }

    // if cart was empty before, unset cart
    if ($_SESSION['cart'] == 0) {
        unset($_SESSION['cart']);
    }
    // If there is not yet another product with the same ID, set the amount to the given amount
    if (!isset($_SESSION['cart']['_' . $ProductID])) {
        $_SESSION['cart']['_' . $ProductID] = $add_aantal;
        // if there already is another product 
    } elseif (isset($_SESSION['cart']['_' . $ProductID])) {
        // maar kan weer niet hoger dan 100, dus dan wordt het gewoon 100
        if ($_SESSION['cart']['_' . $ProductID] + $add_aantal >= 100) {
            $_SESSION['cart']['_' . $ProductID] = 100;
        } else {
            $_SESSION['cart']['_' . $ProductID]+= $add_aantal;
        }
    }
}
?>
    <div class="container col-md-8">
        <h2 class="pb-4">Je winkelmand</h2>

        <?php
        // if session is not 0 ( which means there are items in the cart), the cart will be shown.
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
                        <a href="/WideWorldImporters/single.php?ProductID=<?php echo $id2;?>"><h5 class="plaatje"><?php echo $result[$id2 - 1]['StockItemName']?></h5></a>
                        <h6> Op voorraad.</h6>
                    </div>

                    <div class="col-md-4">

                        <h6 class="aantal" style="float:left">Aantal:</h6>

                        <div class="col-md-12">
                            <!--    print het aantal van het artikel    -->
                            <form method="post">
                                <input class="form-control col-md-3 aantalproducten" type="number" min="1" max="100" name="verander" value="<?php echo $_SESSION['cart'][$id]?>">
                                <input type="hidden" name="post_id" value="<?php echo $id?>">

                            </form>


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
                        <!--    print de prijs van het artikel (replaced komma met punt)  -->
                        <h6> € <?php echo str_replace(".", ",", $result[$id2 - 1]["RecommendedRetailPrice"])?> </h6>
                    </div>


                </div>
                <?php
                // berekend het totaal van de winkelmand
                $totaal+= ($_SESSION['cart'][$id] * $result[$id2 - 1]["RecommendedRetailPrice"]);
            }

            ?>
                <!--    Afreken button en totaalprijs   -->
            <form method="get" action="/WideWorldImporters/afrekenen.php">
                <button style="float:right" type="submit" class="btn large-button">Afrekenen</button>
            </form>

            <h4 style="float:right;margin-right:2%" class="">Totaal: € <?php echo number_format($totaal, 2, ",",".")?> </h4>
                <?php
            }
        else {
            // wanneer ['cart'] dus 0 is is de winkelmand leeg
            echo 'Je winkelmand is leeg';
            echo '<br>';
            ?>
            <form class="mt-3" method="get" action="/WideWorldImporters/index.php">
                <button style="float:left" type="submit" class="btn large-button">< Verder winkelen </button>
            </form>

            <?php
            }
        ?>

    </div>

<?php
require_once './footer.php';
?>