<?php

require_once './connection.php';
require_once './header.php';


// QUERY 1, used for id, name, price
$stmt = $conn->prepare("SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems;");
$stmt->execute();
$result = $stmt->fetchAll();

// QUERY 2, used for getting the amount of stock and Reorderlevel
$stmt2 = $conn->prepare("SELECT StockItemID, QuantityOnHand FROM stockitemholdings;");
$stmt2->execute();
$stock_query = $stmt2->fetchAll();

$total_price = 0;

?>
<div class="container col-xl-8 col-lg-10 col-md-11 col-11">
    <div class="row">
        <div class="col-md-6">
            <h2 class="py-4">Je bestelling</h2>
            <?php
            // if session is not 0 (which means there are items in the cart), the order confirmation will be shown.
            if(!empty($_SESSION["cart"]) || $_SESSION["cart"] != 0) {

                //  add the items in cart to the order and empty cart
                $_SESSION["order"] = $_SESSION["cart"];
                unset($_SESSION["cart"]);

                // loops through every item in the ['cart'] array
                foreach ($_SESSION["order"] as $id => $aantal) {
                    // removes the underscores for the SQL query
                    $id2 = substr($id, 1);
                    ?>

                    <div class="row py-2">
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-12">
                            <?php
                            // checks if there is a picture for the item, if there is, show it.
                            if (file_exists("./images/${id2}-1.jpg")) {
                                ?><img class="img-thumbnail" src="/WideWorldImporters/images/<?php echo $id2?>-1.jpg"><?php
                            } else {
                                // else show a placeholder
                                ?><img class="img-thumbnail" src="https://via.placeholder.com/500"><?php
                            }

                            ?>
                        </div>

                        <div class="col-xl-6 col-lg-4 col-md-5 col-sm-4">
                            <!--    prints the name of the item   -->
                            <a href="/WideWorldImporters/single.php?ProductID=<?php echo $id2;?>"><h5 class="plaatje"><?php echo $result[$id2 - 1]['StockItemName']?></h5></a>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-5">
                            <h6 class="" style="float:left"><?php echo $_SESSION["order"][$id]?> stuks</h6>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-3">
                            <!--    prints the price of the item (replace ',' with '.')  -->
                            <h6 style="float:right"> € <?php echo str_replace(".", ",", $result[$id2 - 1]["RecommendedRetailPrice"])?> </h6>
                        </div>
                    </div>
                    <?php
                    // calculate the total price of every item in the cart

                    $total_price+= ($_SESSION["order"][$id] * $result[$id2 - 1]["RecommendedRetailPrice"]);
                }

                ?>
                <!--  totaalprijs   -->
                <h4 style="float:right">Totaal: € <?php echo number_format($total_price, 2, ",",".")?> </h4>
                <?php
            }
            else {
                echo 'Bestelling mislukt';
            }
            ?>

        </div>
        <div class="col-md-6 pt-5 pr-5">
            <!-- TODO: use real information from session/database -->
            <br><br>
            <h5>Je gegevens</h5>
            <h6>Naam</h6>
            Willibrordus Rutgers
            <br>
            <br>
            <h6>E-mail adres</h6>
            WillibrordusRutgers@jourrapide.com
            <br>
            <br>
            <h6>Adres</h6>
            Kerkstraat 149
            <br>
            5351 EB
            <br>
            <br>
            <h6>Woonplaats</h6>
            Berghem
        </div>
    </div>
</div>
<?php
// checks if text has a value and sends a mail if it has
if ($_SESSION["order"] != 0) {
    $formcontent = '';
    $order = $_SESSION["order"];
    foreach ($order as $item => $value) {
        $formcontent.= "ProductID: " . $item . " Aantal: " . $value;
    }
    // address the mails are sent to
    $recipient = "1@t45.nl";
    $customer_address = "2@t45.nl";
    $subject = "Je bestelling bij WideWorldImporters";
    $mailheader = "From: info@WideWorldImporters.com \r\n";
    // we send 2 mails, 1 to the customer, and 1 to ourselves
    mail($recipient, $subject, $formcontent, $mailheader);
    mail($customer_address, $subject, $formcontent, $mailheader);

}

// lowers the StockItemHoldings by the amount ordered
foreach ($_SESSION["order"] as $item => $value) {
    // removes underscore from string to use it in a query
    $product_id = substr($item, 1);
    // gets the current amount of stock
    $stmt3 = $conn->prepare("SELECT QuantityOnHand FROM stockitemholdings WHERE StockItemID = ${product_id};");
    $stmt3->execute();
    $item_stock = $stmt3->fetch();

    // calculates the new amount of stock
    $new_holdings = $item_stock["QuantityOnHand"] - $value;

    // sets the new stock amount in the database
    $update_stock = "UPDATE stockitemholdings SET QuantityOnHand = ${new_holdings} WHERE StockItemID = ${product_id};";
    $conn->exec($update_stock);
}

// TODO: uncomment when done with development
// unsets the order sessions when the order is processed
//unset($_SESSION["order"];



require_once './footer.php';

?>