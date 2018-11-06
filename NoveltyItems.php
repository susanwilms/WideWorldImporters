<?php

require_once 'connection.php';
require_once 'header.php';
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmtcat1 = $conn->prepare("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = 1;");
$stmtcat1->execute();
$resultcat1 = $stmtcat1->fetchAll();
$conn = null;
?>
<div class="container pt-5">
    <div class="row">
        <?php
        foreach($resultcat1 as $r){
            $stock_id = $r[0];
            $stock_name = $r[1];
            $stock_price = $r[2];
            ?>
            <div class="col-md-4 pb-2">
                <div class="card mb-4 text-center" style="background-color:rgb(155, 155, 155);">
                    <div class="card-body text-center text-white">
                        <p class="text-left card-text"><span style="float:right;"><?php echo $stock_name; ?></span></p>
                        <p class="text-left card-text">Prijs:<span style="float:right;"><?php echo $stock_price; ?></span></p>
                    </div>
                    <a href="images/placeholder.png">
                        <img class="card-img" src="images/placeholder.png" alt="<?php echo $stock_name; ?>">
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>

<?php
    require_once 'footer.php';
?>
