<?php
require_once 'connection.php';
require_once 'header.php';

##<--!All variables used in this document-->

$productgroup=filter_input(INPUT_GET, "productgroup", FILTER_SANITIZE_STRING);
$sort=filter_input(INPUT_GET, "sort", FILTER_SANITIZE_STRING);
$limit=filter_input(INPUT_GET, "limit", FILTER_SANITIZE_STRING);

$generalURL= "/WideWorldImporters/Categories.php?productgroup=". $productgroup;

// zet limit standaard op 24, de default waarde
if(empty($limit)){
    $limit=24;
}

// zet sorteer standaard op 0 wanneer deze niet geset is (de default sort dus)
if(!isset($sort)){
    $sort = 0;
}

// array met alle mogelijke sorteer opties
$sort_options = array (0 => "sisg.StockItemID ASC", 1 => "UnitPrice ASC", 2 => "UnitPrice DESC");
$sorted = $sort_options[$sort];

##<----------------------------------------------->


##<-- SQL querry en connection configuration -->

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmtcat1 = $conn->prepare("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = :groupid ORDER BY ${sorted} LIMIT :limit;");
$stmtcat1->bindParam(':groupid', $productgroup);
$stmtcat1->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmtcat1->execute();
$resultcat1 = $stmtcat1->fetchAll();
$conn = null;

##<------------------------------------------------->


##<-- Generation of random review stars-->

$driester = "<span>★</span><span>★</span><span>★</span><span>☆</span><span>☆</span>";
$vierster = "<span>★</span><span>★</span><span>★</span><span>★</span><span>☆</span>";
$vijfster = "<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>";

$array = array($driester, $vierster, $vijfster);

##<---------------------------------------->

?>

<style xmlns="http://www.w3.org/1999/html">

/*TODO: verplaatsen naar style.css*/

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
        width: 70%;
    }
    .btn-group button {
        padding: 0px 10px;  /*Some padding */
        float: right; /* Float the buttons side by side */
    }

    #test{
        margin-top: 5%;
        text-align: center;

    }
    #test #Element {
    display: inline-block;
    }
    #test #Element:first-child {
        display: inline-block;
        margin-left: 3%;
    }

    #Element {
        margin-right: 10%;

    }


</style>

<script>

    function listView(){
        $('#categorieen > div').removeClass('col-md-3').addClass('col-md-12');
    }

    function gridView(){
        $('#categorieen > div').addClass('col-md-3').removeClass('col-md-12');
    }

    // werkt niet
    //
    // /* Optional: Add active class to the current button (highlight it) */
    // var container = document.getElementById("btnContainer");
    // var btns = container.getElementsByClassName("btn");
    // for (var i = 0; i < btns.length; i++) {
    //     btns[i].addEventListener("click", function(){
    //         var current = document.getElementsByClassName("active");
    //         current[0].className = current[0].className.replace(" active", "");
    //         this.className += " active";
    //     });
    // }
</script>

<div id="main_container">
    <div class="container pt-4">
        <!-- This is the category photo -->
        <img id="img_productgroup" src="/WideWorldImporters/images/productgroup<?php print($productgroup);?>.jpg">

        <!-- This is the different sorting element above the items -->
        <div id="test">
                <div id="Element">
                    Pagina  << < 1 van 2 > >>
                </div>
                <div id="Element">
                    Sorteer op:
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">

                </button>
                    <div class="dropdown-menu">
                    <!-- TODO: zorgen dat er zichtbaar is welke button aangeklikt is, dmv 'active' class -->
                        <a class="dropdown-item" href="<?php echo $generalURL . "&sort=0&limit=${limit}"; ?>">Standaard</a>
                        <a class="dropdown-item" href="<?php echo $generalURL . "&sort=1&limit=${limit}"; ?>">Prijs oplopend</a>
                        <a class="dropdown-item" href="<?php echo $generalURL . "&sort=2&limit=${limit}"; ?>">Prijs aflopend</a>
                    </div>
                </div>


                <div id="Element">
                    Aantal:
                <div class="btn-group">
                <!-- TODO: zorgen dat er zichtbaar is welke button aangeklikt is, dmv 'active' class -->
                    <button class="btn btn-secondary" onclick="location.href='<?php echo $generalURL . "&sort=${sort}&limit=24"; ?>'">24</button>
                    <button class="btn btn-secondary" onclick="location.href='<?php echo $generalURL . "&sort=${sort}&limit=48"; ?>'">48</button>
                    <button class="btn btn-secondary" onclick="location.href='<?php echo $generalURL . "&sort=${sort}&limit=96"; ?>'">96</button>
                </div>
                </div>
                <div id="Element">
                    <button class="btn" onclick="listView()"><i class="fa fa-bars"></i> List</button>
                    <button class="btn" onclick="gridView()"><i class="fa fa-th"></i> Grid</button>
                </div>

        </div>

        <!-- End of Sorting Elements -->

        <?php


        ?>

        <!-- These are the items -->
        <div class="row" id="categorieen">

            <?php
            if(!empty($resultcat1)){
            foreach($resultcat1 as $r){
                $stock_id = $r[0];
                $stock_name = $r[1];
                $stock_price = $r[2];
                ?>
                <div class="col-md-3 col-12 pb-2">
                    <div class="card mb-4 text-center" style="background-color:rgb(155, 155, 155);">
                        <a href="/WideWorldImporters/single.php?ProductID=<?php echo $stock_id?>">
                            <img class="card-img" src="images/<?php print("PicProduct".$stock_id)?>.png" alt="<?php echo $stock_name?>" onerror="this.src='/WideWorldImporters/images/placeholder.png';"/>
                        </a>
                        <div class="card-body text-center text-white">
                            <p class="text-left card-text"><span style="float:left;"><?php echo $stock_name; ?></span></p><br>
                            <p class="text-left card-text"><span style="float:left;"><?php echo "Prijs: ".$stock_price; ?></span></p>
                            <p><?php echo $array[array_rand($array)]; ?></p>
                        </div>
                    </div>
                </div>
            <?php } }else{
                echo "This category is empty.";
            }?>
        </div>

        <!-- End of items -->
    </div>
</div>

</body>

<?php
    require_once 'footer.php';
?>
