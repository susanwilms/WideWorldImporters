<?php

require_once 'connection.php';
require_once 'header.php';


$groupid=filter_input(INPUT_GET, "Productgroup", FILTER_SANITIZE_STRING);
$sort=filter_input(INPUT_GET, "sort", FILTER_SANITIZE_STRING);


if(empty($sort)){
    $sort="sisg.StockItemID";
}

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmtcat1 = $conn->prepare("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = $groupid ORDER BY $sort;");
$stmtcat1->execute();
$resultcat1 = $stmtcat1->fetchAll();
$conn = null;


?>
<style>
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
    #main_container div{
        top: 10%;
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

    <div id="test">
        <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                Sort by
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?php $productgroup=$groupid; print('/WideWorldImporters/Categories.php?Productgroup='.$productgroup.'&sort=UnitPrice ASC')?>">Van laag naar hoog</a>
                <a class="dropdown-item" href="<?php $productgroup=$groupid; print('/WideWorldImporters/Categories.php?Productgroup='.$productgroup.'&sort=UnitPrice DESC')?>">Van hoog naar laag</a>
            </div>
        </div>
        <div id="btnContainer">
            <button class="btn" onclick="listView()"><i class="fa fa-bars"></i> List</button>
            <button class="btn active" onclick="gridView()"><i class="fa fa-th"></i> Grid</button>
        </div>
        <script>

            function listView(){
                $('#categorieen > div').removeClass('col-md-3').addClass('col-md-12');
            }

            function gridView(){
                $('#categorieen > div').addClass('col-md-3').removeClass('col-md-12');
            }

            /* Optional: Add active class to the current button (highlight it) */
            var container = document.getElementById("btnContainer");
            var btns = container.getElementsByClassName("btn");
            for (var i = 0; i < btns.length; i++) {
                btns[i].addEventListener("click", function(){
                    var current = document.getElementsByClassName("active");
                    current[0].className = current[0].className.replace(" active", "");
                    this.className += " active";
                });
            }
        </script>


        <div class="btn-group">
            Aantal:
            <button type="button" class="btn btn-secondary" onclick>24</button>
            <button type="button" class="btn btn-secondary">48</button>
            <button type="button" class="btn btn-secondary">96</button>
        </div>
    </div>


    <div class="row" id="categorieen">

        <?php
        foreach($resultcat1 as $r){
            $stock_id = $r[0];
            $stock_name = $r[1];
            $stock_price = $r[2];
            ?>
            <div class="col-md-3 col-12 pb-2">
                <div class="card mb-4 text-center" style="background-color:rgb(155, 155, 155);">
                    <a href="/WideWorldImporters\single.php?ProductID=<?php echo $stock_id?>">
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
