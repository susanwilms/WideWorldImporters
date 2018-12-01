<?php
require_once 'connection.php';
require_once 'header.php';


// QUERY 1, used for getting the customers information
$id=$_SESSION['id'];
$stmt = $conn->prepare("SELECT OrderID , OrderDate , ExpectedDeliveryDate  FROM orders WHERE CustomerID = $id;");
$stmt->execute();
$orders = $stmt->fetchAll();

//If the click on one of the orders this variable wil get a value
$order="";
$order=(int)filter_input(INPUT_GET, "order", FILTER_SANITIZE_STRING);

if(!empty($order)){
    $stmt = $conn->prepare("SELECT StockItemID, Description, Quantity,UnitPrice  FROM orderlines WHERE OrderID  = :orderid;");
    $stmt->bindParam(":orderid", $param_orderid, PDO::PARAM_INT);
    $param_orderid=$order;

    $stmt->execute();
    $orderlines = $stmt->fetchAll();
    $stmt= null;
}
?>
    <link rel="stylesheet" href="myaccount.css">

    <nav class="navbar-primary">
        <a href="#" class="btn-expand-collapse"><span class="glyphicon glyphicon-menu-left"></span></a>
        <ul class="navbar-primary-menu">
            <li>
                <a class="" href="myaccount.php"><span class="glyphicon glyphicon-list-alt"></span><span class="nav-label">Mijn Account</span></a>
                <a class="activenav" href="orderhistory.php"><span class="glyphicon glyphicon-envelope"></span><span class="nav-label">Mijn bestellingen</span></a>
                <a href="destroy.php"><span class="glyphicon glyphicon-cog"></span><span id="destroy" class="nav-label">Uitloggen</span></a>
            </li>
        </ul>
    </nav>
    <div class="main-content">
        <h1> Mijn bestellingen</h1>
        <div class="col-md-6 pt-5 pr-5">

            <?php
            if(empty($order)){
            if(!empty($orders)){
                ?>
            <table>
                <tr>
                    <th>Ordernummer</th>
                    <th>Orderdatum</th>
                    <th>Verwachte aankomst</th>
                </tr>

                <?php
                foreach ($orders as $r) {
                    $ordernumber = $r[0];
                    $orderdate = $r[1];
                    $expecteddeleverydate = $r[2];
 ?>

                        <tr>
                            <td><?php echo "<a href='orderhistory.php?order=$ordernumber'>$ordernumber</a>";?></td>
                            <td><?php echo "$orderdate";?></td>
                            <td><?php echo "$expecteddeleverydate";?></td>
                        </tr>




                <?php
                }?>
                </table>
                <?php
            }else{
                echo "<h5>U hebt geen geregistreerde bestellingen<h5><br>";
                echo "<a href='Categories.php'><button type=\"button\" class=\"btn btn-info\">Naar de winkel</button></a>";
            }}else{
                ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Omschrijving</th>
                    <th>Aantal</th>
                    <th>Prijs per product</th>
                </tr>

                <?php
                foreach($orderlines as $r){
                    $StockItemID= $r[0];
                    $Description=$r[1];
                    $Quantity=$r[2];
                    $UnitPrice=$r[3];

                    ?>
                    <tr>
                        <td><?php echo "<img src='images/$StockItemID-1.jpg' style='height: 100px'>";?></td>
                        <td><?php echo "$Description";?></td>
                        <td><?php echo "$Quantity";?></td>
                        <td><?php echo "$UnitPrice"?></td>
                    </tr>

                    <?php
                }
                ?>
            </table>
                <?php
            }
            ?>
        </div>
    </div>



<?php
require_once 'footer.php';
?>