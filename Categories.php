<?php

require_once 'connection.php';
require_once 'header.php';
$groupid=filter_input(INPUT_GET, "Productgroup", FILTER_SANITIZE_STRING);
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmtcat1 = $conn->prepare("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = $groupid;");
$stmtcat1->execute();
$resultcat1 = $stmtcat1->fetchAll();
$conn = null;
if(isset($_POST['nw_update']))
    "SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = $groupid ORDER BY si.UnitPrice"
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
    .btn-group button {
        border: 1px solid rbg(155, 255, 155);
        color: white; /* White text */
        padding: 5px 10px; /* Some padding */
        cursor: pointer; /* Pointer/hand icon */
        float: left; /* Float the buttons side by side */
    }



</style>
<div id="main_container">
<div class="container pt-4">
<img id="img_productgroup" src="/WideWorldImporters/images/productgroup1.jpg">
<<<<<<< HEAD
    <form method="POST" action="Categories.php">
        <input type="submit" name="Sorteer op prijs van laag naar hoog" value="Sorteer op prijs van laag naar hoog"/>
    </form>
    <script>
        function Sort_Function2(){
            document.getElementById("HnL").statement = "SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = $groupid ORDER BY si.UnitPrice DESC";
        }
    </script>
=======
    <div id="test">
        <button onclick="sorteerfunctie()">Sorteer op prijs</button>
        <div class="btn-group">
            Aantal:
            <button type="button" class="btn btn-secondary" onclick>24</button>
            <button type="button" class="btn btn-secondary">48</button>
            <button type="button" class="btn btn-secondary">96</button>
        </div>
    </div>
>>>>>>> e48174f2d943d85eba4b528b0c19e095e752017e

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
