<?php

require_once 'connection.php';
require_once 'header.php';


// all variables used in this document
$productgroup = (int)filter_input(INPUT_GET, "productgroup", FILTER_SANITIZE_STRING);
$sort = (int)filter_input(INPUT_GET, "sort", FILTER_SANITIZE_STRING);
$limit = (int) filter_input(INPUT_GET, "limit", FILTER_SANITIZE_STRING);
$page = (int) filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING);

$generalURL = "/WideWorldImporters/Categories.php?productgroup=". $productgroup;


// set limit to 24 if it isn't set (default limit)
if(empty($limit)){
    $limit=24;
}

// set sort to 0 if it isn't set (default sort)
if(empty($sort)){
    $sort = 0;
}

// standard page has to be 0 even if user presses page 1
if(empty($page) || $page==1){
    $pages=0;
}else{
    $pages=($page*$limit)-$limit; // algorithm to determine the first number of the limit
}

// array with all possible sort options
$sort_options = array (0 => "sisg.StockItemID ASC", 1 => "UnitPrice ASC", 2 => "UnitPrice DESC");
$sorted = $sort_options[$sort];


// QUERY 1, for getting the itemID, Name, and price.
$stmtcat = $conn->prepare("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = :groupid ORDER BY ${sorted} LIMIT :page,:limit;");
$stmtcat->bindParam(':groupid', $productgroup);
$stmtcat->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmtcat->bindParam(':page', $pages, PDO::PARAM_INT);
$stmtcat->execute();
$resultcat1 = $stmtcat->fetchAll();

// QUERY 2, used for counting the amount of records in an item group, for pagination
$nRows = $conn->query("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = $productgroup")->rowCount();
$Pagesamount = $nRows/$limit;
$Pagesamount = ceil($Pagesamount); // determine amount of pages

$conn = null;


// generation of random review stars
$threestar = "<span>★</span><span>★</span><span>★</span><span>☆</span><span>☆</span>";
$fourstar = "<span>★</span><span>★</span><span>★</span><span>★</span><span>☆</span>";
$fivestar = "<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>";

$array = array($threestar, $fourstar, $fivestar);

?>

<script>

    function listView(){
        $('#Categories > div').removeClass('col-md-3').addClass('col-md-12');
    }

    function gridView(){
        $('#Categories > div').addClass('col-md-3').removeClass('col-md-12');
    }

    // doesn't work
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
    <div class="container ">
        <!-- This is the category photo -->
        <img id="img_productgroup" src="/WideWorldImporters/images/productgroup<?php print($productgroup);?>.jpg">

        <!-- This is the different sorting element above the items -->
        <div id="test">

            <!--Pagination-->
                <div id="Element">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            if($page>1 ) {

                                ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?php echo "$generalURL&sort=${sort}&limit=${limit}&page=";
                                       echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Vorige</span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            //Generate the amount of pages needed
                            for($i=1; $i<=$Pagesamount; $i++){
                                ?>
                                <li class="page-item"><a class="page-link" href="<?php echo "$generalURL&sort=${sort}&limit=${limit}&page=${i}";?>"><?php echo $i ?></a></li>
                                <?php
                            }?>
                            <?php
                            if($page<$Pagesamount) {
                                ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo "$generalURL&sort=${sort}&limit=${limit}&page=";
                                    echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                <?php
                            }?>
                        </ul>
                    </nav>
                </div>
                <div id="Element">
                    Sorteer:
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"></button>
                    <div class="dropdown-menu">
                    <!-- TODO: Make sure it's visible which button is pressed, dmv 'active' class -->
                        <a class="dropdown-item" href="<?php echo "$generalURL&sort=0&limit=${limit}&page=${page}" ?>">Standaard</a>
                        <a class="dropdown-item" href="<?php echo "$generalURL&sort=1&limit=${limit}&page=${page}" ?>">Prijs laag naar hoog</a>
                        <a class="dropdown-item" href="<?php echo "$generalURL&sort=2&limit=${limit}&page=${page}" ?>">Prijs hoog naar laag</a>
                    </div>
                </div>


                <div id="Element">
                    Aantal:
                <div class="btn-group">
                <!-- TODO: Make sure it's visible which button is pressed, dmv 'active' class -->
                    <button class="btn btn-secondary" onclick="location.href='<?php echo $generalURL . "&sort=${sort}&limit=24&page=1"; ?>'">24</button>
                    <button class="btn btn-secondary" onclick="location.href='<?php echo $generalURL . "&sort=${sort}&limit=48&page=1"; ?>'">48</button>
                    <button class="btn btn-secondary" onclick="location.href='<?php echo $generalURL . "&sort=${sort}&limit=96&page=1"; ?>'">96</button>
                </div>
                </div>
                <div id="Element">
                    <button class="btn" onclick="listView()"><i class="fa fa-bars"></i> List</button>
                    <button class="btn" onclick="gridView()"><i class="fa fa-th"></i> Grid</button>
                </div>

        </div>
        <!-- End of Sorting Elements -->


        <!-- These are the items -->
        <div class="row" id="Categories">

            <?php
            if(!empty($resultcat1)){
            foreach($resultcat1 as $r){
                $stock_id = $r[0];
                $stock_name = $r[1];
                $stock_price = $r[2];
                ?>
                <div class="col-md-3 col-12 pb-2 no-radius">
                    <div class="card mb-4 text-center no-radius" style="background-color:rgb(155, 155, 155);">
                        <a href="/WideWorldImporters/single.php?ProductID=<?php echo $stock_id?>">
                            <img class="card-img no-radius" src="images/<?php print("PicProduct".$stock_id)?>.png" alt="<?php echo $stock_name?>" onerror="this.src='/WideWorldImporters/images/placeholder.png';"/>
                        </a>
                        <div class="card-body text-center text-white no-radius">
                            <p class="text-left card-text"><span style="float:left;"><?php echo $stock_name; ?></span></p><br>
                            <p class="text-left card-text"><span style="float:left;"><?php echo "Prijs: ".$stock_price; ?></span></p>
                            <p><?php echo $array[array_rand($array)]; ?></p>
                        </div>
                    </div>
                </div>
            <?php } }else{
                echo "Deze categorie is leeg.";
            }?>
        </div>

        <!-- End of items -->
    </div>
</div>

</body>

<?php
    require_once 'footer.php';
?>
