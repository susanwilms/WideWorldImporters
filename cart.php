<?php
require_once "./connection.php";
require_once "./header.php";


// QUERY 1, used for id, name, price
$stmt = $conn->prepare("SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems;");
$stmt->execute();
$result = $stmt->fetchAll();

// QUERY 2, used for getting the amount of stock and Reorderlevel
$stmt2 = $conn->prepare("SELECT StockItemID, QuantityOnHand FROM stockitemholdings;");
$stmt2->execute();
$stock_query = $stmt2->fetchAll();


// checks if there is something in the cart. if not, cart = 0.
if(!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = 0;
}

$total_price = 0;


// checks if remove_item has a value and if there's an article that has to be deleted
if (filter_has_var(INPUT_POST, "remove_item")) {
    // gets the product id from the hidden field
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $remove_item = filter_input(INPUT_POST, "remove_item", FILTER_SANITIZE_STRING);

    // checks if there's a product in the cart, if so, it deletes the product from the cart
    if (isset($_SESSION["cart"][$post_id])) {
        unset($_SESSION["cart"][$post_id]);
    }

    // checks if there are any more products in the cart
    if (count($_SESSION["cart"]) == 0) {
        // if there's nothing left in the cart, it deletes the whole session and sets it to 0
        unset($_SESSION["cart"]);
        $_SESSION["cart"] = 0;
    }
}


// checks if decrease_quantity has a value and if there is a product that needs to be lowered in amount
if (filter_has_var(INPUT_POST, "decrease_quantity")) {
    // gets the product id from the hidden field
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $decrease_quantity = filter_input(INPUT_POST, "decrease_quantity", FILTER_SANITIZE_STRING);

    // if the amount is already 1, it doesn't lower the amount but it removes the product from the cart instead
    if ($_SESSION["cart"][$post_id] == 1) {
        // unset the product so it's removed from the cart
        unset($_SESSION["cart"][$post_id]);

        // checks if there are any other products in the cart
        if (count($_SESSION["cart"]) == 0) {
            // if there's nothing left in the cart, it deletes the whole session and sets it to 0
            unset($_SESSION["cart"]);
            $_SESSION["cart"] = 0;
        }

    } elseif (isset($_SESSION["cart"][$post_id])) {
        if ($_SESSION["cart"][$post_id] > 1)
            // anders gaat het aantal gewoon 1 omlaag
            $_SESSION["cart"][$post_id]--;
    }
}


// checks if raise has a value and if there is a product that needs raising in amount
if (filter_has_var(INPUT_POST, "increase_quantity")) {
    // gets the product id from the hidden field
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $increase_quantity = filter_input(INPUT_POST, "increase_quantity", FILTER_SANITIZE_STRING);

    // only increase the quantity if the quantity is lower than 100, because that's the set limit
    if ($_SESSION["cart"][$post_id] < 100) {
        // raises the product with $post_id by 1
        $_SESSION["cart"][$post_id]++;
        // else: don't increase the quantity, and show an alert
    } else {
        ?>
        <div class="pt-2 container col-sm-8 col-11">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Sorry,</strong> je kan maximaal 100 stuks van een artikel tegelijk bestellen.
            </div>
        </div>
        <?php
    }
}


// checks if modify_quantity has a value and if there is a product that needs changing
if (filter_has_var(INPUT_POST, "modify_quantity")) {
    // gets the product id from the hidden field
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_STRING);
    $modify_quantity = filter_input(INPUT_POST, "modify_quantity", FILTER_SANITIZE_STRING);

    // the changed quantity has to be 100 or less at all times
    if ($modify_quantity > 100) {
        $modify_quantity = 100;
    }

    // the changed quantity has to be 1 or more at all times
    if ($modify_quantity < 1) {
        $modify_quantity = 1;
    }

    // sets the quantity to the new quantity
    $_SESSION["cart"][$post_id] = $modify_quantity;
}


// takes stuff from the single.php POST, and puts it in an array
if (filter_has_var(INPUT_POST, "productID")) {
    // gets the product id from the hidden field
    $ProductID = filter_input(INPUT_POST, "productID", FILTER_SANITIZE_STRING);
    // the amount that should be added
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
    if ($_SESSION["cart"] == 0) {
        unset($_SESSION["cart"]);
    }
    // If there is not yet another product with the same ID, set the amount to the given amount
    if (!isset($_SESSION["cart"]["_" . $ProductID])) {
        $_SESSION["cart"]["_" . $ProductID] = $add_aantal;
        // if there already is another product
    } elseif (isset($_SESSION["cart"]["_" . $ProductID])) {
        // the total amount can't be higher than 100, so we set it to 100 if it is.
        if ($_SESSION["cart"]["_" . $ProductID] + $add_aantal >= 100) {
            $_SESSION["cart"]["_" . $ProductID] = 100;
        } else {
            $_SESSION["cart"]["_" . $ProductID]+= $add_aantal;
        }
    }
}

?>
    <div class="container col-xl-8 col-lg-10 col-md-11 col-11">
        <h2 class="py-4">Je winkelmand</h2>
        <?php
        // if session is not 0 (which means there are items in the cart), the cart will be shown.
        if($_SESSION["cart"] != 0) {

            // loops through every item in the ["cart"] array
            foreach ($_SESSION["cart"] as $id => $aantal) {
                // removes the underscores for the SQL query
                $id2 = substr($id, 1);
                ?>

                <div class="row py-2">
                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-3 col-12">
                        <?php
                        // checks if there is a picture for the item, if there is, show it.
                        if (file_exists("./images/${id2}-1.jpg")) {
                            ?><a href="/WideWorldImporters/single.php?ProductID=<?php echo $id2;?>"><img class="img-thumbnail" src="/WideWorldImporters/images/<?php echo $id2?>-1.jpg"></a><?php
                        } else {
                            // else show a placeholder
                            ?><a href="/WideWorldImporters/single.php?ProductID=<?php echo $id2;?>"><img class="img-thumbnail" src="https://via.placeholder.com/500"></a><?php
                        }
                        ?>

                    </div>

                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-3">
                        <!--    prints the name of the item   -->
                        <a href="/WideWorldImporters/single.php?ProductID=<?php echo $id2;?>"><h5 class="plaatje"><?php echo $result[$id2 - 1]["StockItemName"]?></h5></a>
                        <?php
                        if ($stock_query[$id2 - 1]["QuantityOnHand"] > 100) {
                            print("<h6 style='color:green'> Op voorraad.</h6>");
                        } elseif ($stock_query[$id2 - 1]["QuantityOnHand"] <= 0) {
                            print("<h6 style='color:red'> Geen voorraad.</h6>");
                        } else {
                            print("<h6 style='color:orange'> Weinig voorraad.</h6>");
                        }
                        ?>

                    </div>

                    <div class="col-xl-5 col-lg-5 col-md-4 col-sm-6 col-9">
                        <h6 class="amount d-none d-lg-block" style="float:left">Aantal:</h6>
                        <div class="">
                            <!--    prints the quantity of the item    -->
                            <form method="post">
                                <input class="form-control col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 productamount" type="number" min="1" max="100" name="modify_quantity" value="<?php echo $_SESSION["cart"][$id]?>">
                                <input type="hidden" name="post_id" value="<?php echo $id?>">
                            </form>
                            <div class="col-md-12 col-sm-12">
                                <!--    remove from cart   -->
                                <form method="post" action=""  class="form-delete-button">
                                    <!--    sends a hidden field with the id of the product that should be deleted  -->
                                    <input name="post_id" type="hidden" value="<?php echo $id?>">
                                    <button type="submit" name="remove_item" value="1" class="btn btn-secondary">&times;</button>
                                </form>

                                <!--    decrease of quantity      -->
                                <form method="post" action="" class="form-button">
                                    <!--    sends a hidden field with the id of the product that should be decreased  -->
                                    <input name="post_id" type="hidden" value="<?php echo $id?>">
                                    <button type="submit" name="decrease_quantity" value="1" class="btn btn-secondary">&minus;</button>
                                </form>

                                <!--    increase of quantity     -->
                                <form method="post" action="" class="form-button">
                                    <!--    sends a hidden field with the id of the product that should be increased  -->
                                    <input name="post_id" type="hidden" value="<?php echo $id?>">
                                    <button type="submit" name="increase_quantity" value="1" class="btn btn-secondary">&plus;</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-3">
                        <!--    prints the price of the item (replace "," with ".")  -->
                        <h6 style="float:right"> € <?php echo str_replace(".", ",", $result[$id2 - 1]["RecommendedRetailPrice"])?> </h6>
                    </div>
                </div>
                <?php
                // calculate the total price of every item in the cart
                $total_price+= ($_SESSION["cart"][$id] * $result[$id2 - 1]["RecommendedRetailPrice"]);
            }

            ?>
            <!--    Checkout button and total price   -->
            <form method="get" action="/WideWorldImporters/checkout.php">
                <button style="float:right; margin-bottom:20px" type="submit" class="btn large-button">Afrekenen</button>
            </form>
            <!--       number_format to get print the price in a nice way     -->
            <h4 style="float:right;margin-right:2%" class="">Totaal: € <?php echo number_format($total_price, 2, ",",".")?> </h4>
            <?php
        }
        else {
            // when ["cart"] is 0, the cart is empty
            echo "Je winkelmand is leeg";
            echo "<br>";
            ?>
            <form class="mt-3" method="get" action="/WideWorldImporters/index.php">
                <button style="float:left" type="submit" class="btn large-button">< Verder winkelen </button>
            </form>

            <?php
        }
        ?>

    </div>

<?php
require_once "./footer.php";
?>