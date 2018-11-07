<?php

require_once 'connection.php';
require_once 'header.php';


$groupid=filter_input(INPUT_GET, "Productgroup", FILTER_SANITIZE_STRING);
$sort=filter_input(INPUT_GET, "sort", FILTER_SANITIZE_STRING);
$productgroup=$groupid;
$generalURL= "/WideWorldImporters/Categories.php?Productgroup=". $productgroup;
$gesorteerd=FALSE;
$gesorteerd = false;
if(isset($_GET['gesorteerd'])){
    $gesorteerd = (boolean)$_GET['gesorteerd'];
}


if(empty($sort)){
    $sort="sisg.StockItemID";
}

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmtcat1 = $conn->prepare("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = $groupid ORDER BY $sort LIMIT");
$stmtcat1->execute();
$resultcat1 = $stmtcat1->fetchAll();
$conn = null;


?>
<style xmlns="http://www.w3.org/1999/html">
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
    .btn-group a {
        padding: 5px 10px; /* Some padding *
        float: left; /* Float the buttons side by side */
    }
    .btn-group a:active {

    }



</style>
<div id="main_container">
<div class="container pt-4">
<img id="img_productgroup" src="/WideWorldImporters/images/productgroup1.jpg">



    <div id="test">
        <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                Sort by
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?php makeUrl($generalURL, 'ASC'); ?>">Van laag naar hoog</a>
                <a class="dropdown-item" href="<?php makeUrl($generalURL, 'DESC'); ?>">Van hoog naar laag</a>
                <?php
                function makeUrl($theUrl, $sortby){
                    global $temporyURL;
                    $temporyURL = "$theUrl&sort=UnitPrice $sortby&gesorteerd=1";

                    print($temporyURL);
                }
                ?>
            </div>
        </div>

        <div class="btn-group">
            Aantal:
            <button class="btn btn-secondary" onclick="location.href='<?php
            if(!$gesorteerd){
                $temporyURL2=$generalURL;
                $temporyURL2=$temporyURL2 . "&LIMIT=24";
                print($temporyURL2);
            }else{
                $temporyURL=$temporyURL . "&LIMIT=24";
                print($temporyURL);
            }

            ?>'">24</button>
            <button class="btn btn-secondary" onclick="location.href='<?php
            if(!$gesorteerd){
                $temporyURL2=$generalURL;
                $temporyURL2=$temporyURL2 . "&LIMIT=48";
                print($temporyURL2);
            }else{
                $temporyURL==$temporyURL . "&LIMIT=48";
            }

            ?>'" >48</button>
            <button class="btn btn-secondary" onclick="location.href='<?php
            if(!$gesorteerd){
                $temporyURL2=$generalURL;
                $temporyURL2=$temporyURL2 . "&LIMIT=96";
                print($temporyURL2);
            }else{
                $temporyURL==$temporyURL . "&LIMIT=96";
            }

            ?>'" >96</button>
        </div>
    </div>

    <?php


    ?>

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
