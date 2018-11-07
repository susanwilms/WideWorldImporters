<?php

require_once 'connection.php';
require_once 'header.php';
$groupid=filter_input(INPUT_GET, "Productgroup", FILTER_SANITIZE_STRING);
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmtcat1 = $conn->prepare("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = $groupid;");
$stmtcat1->execute();
$resultcat1 = $stmtcat1->fetchAll();
$conn = null;
?>
<style>
    #main_container div{
        top: 10%
    }
    #img_productgroup{
        margin-top: 5%;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
</style>
<div id="main_container">
<div class="container pt-5">
<img id="img_productgroup" src="/WideWorldImporters/images/productgroup1.jpg">
    <button onclick="sorteerfunctie()">Sorteer op prijs</button>

    <div class="row">

        <?php
        foreach($resultcat1 as $r){
            $stock_id = $r[0];
            $stock_name = $r[1];
            $stock_price = $r[2];
            ?>
            <div class="col-md-3 pb-2">
                <div class="card mb-4 text-center" style="background-color:rgb(155, 155, 155);">
                    <a href="/WideWorldImporters\single_item_page\single.php?ProductID=<?php echo $stock_id?>">
                        <img class="card-img" src="images/<?php print("PicProduct".$stock_id)?>.png" alt="<?php echo $stock_name?>" onerror="this.src='/WideWorldImporters/images/placeholder.png';"/>
                    </a>
                    <div class="card-body text-center text-white">
                        <p class="text-left card-text"><span style="float:left;"><?php echo $stock_name; ?></span></p><br>
                        <p class="text-left card-text"><span style="float:left;"><?php echo "Prijs: ".$stock_price; ?></span></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</div>

</body>

<?php
    require_once 'footer.php';
?>
