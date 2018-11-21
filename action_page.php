<?php

require_once 'header.php';
require_once 'connection.php';


// All variables used in this document
$description = filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING);
$sort = (int)filter_input(INPUT_GET, "sort", FILTER_SANITIZE_STRING);
$limit = (int) filter_input(INPUT_GET, "limit", FILTER_SANITIZE_STRING);
$page = (int) filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING);

$generalURL = "/WideWorldImporters/action_page.php?search=". $description;

// set limit to 24 if it isn't set (default limit)
if(empty($limit)){
    $limit = 24;
}

// set sort to 0 if it isn't set (default sort)
if(empty($sort)){
    $sort = 0;
}

// standard page has to be 0 even if user presses page 1.
if(empty($page) || $page == 1){
    $pages = 0;
}else{
    $pages = ($page * $limit) - $limit; // algorithm to determine the first number of the limit
}

// array with all possible sort options
$sort_options = array (0 => "si.StockItemID ASC", 1 => "UnitPrice ASC", 2 => "UnitPrice DESC");
$sorted = $sort_options[$sort];


// QUERY 1, for getting the itemID, Name, and price.
$stmt_search = $conn->prepare("SELECT si.StockItemID, si.StockItemName, si.UnitPrice FROM stockitems si WHERE si.SearchDetails LIKE '%${description}%' ORDER BY ${sorted} LIMIT :page,:limit;");
$stmt_search->bindParam(':page', $pages, PDO::PARAM_INT);
$stmt_search->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt_search->execute();
$resultcat1 = $stmt_search->fetchAll();

// QUERY 2, used for counting the amount of records in a search query, for pagination
$nRows = $conn->query("SELECT si.StockItemID, si.StockItemName, si.UnitPrice FROM stockitems si WHERE si.SearchDetails LIKE '%${description}%'")->rowCount();
$aantalPages = $nRows / $limit;
$aantalPages = ceil($aantalPages); // determine amount of pages

$conn = NULL;


// generation of random review stars
$threestar = "<span>★</span><span>★</span><span>★</span><span>☆</span><span>☆</span>";
$fourstar = "<span>★</span><span>★</span><span>★</span><span>★</span><span>☆</span>";
$fivestar = "<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>";

$array = array($threestar, $fourstar, $fivestar);

?>
<!-- Script for list or grid view -->
<script>

    function listView(){
        $('#categorieen > div').removeClass('col-md-3').addClass('col-md-12');
    }

    function gridView(){
        $('#categorieen > div').addClass('col-md-3').removeClass('col-md-12');
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
    //
    // }
</script>


    <?php
    if($nRows == 0){

        echo  "Geen artikelen gevonden";} else {
        ?>

    <div id="main_container">
        <div class="container pt-4">
            <!-- This is the different sorting element above the items -->
            <div id="test">
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
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            //Generate the amount of pages needed
                            for($i=1; $i<=$aantalPages; $i++){
                                ?>
                                <li class="page-item"><a class="page-link" href="<?php echo "$generalURL&sort=${sort}&limit=${limit}&page=${i}";?>"><?php echo $i ?></a></li>
                                <?php
                            }?>
                            <?php
                            if($page<$aantalPages) {
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
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">

                    </button>
                    <div class="dropdown-menu">
                    <!-- TODO: Make sure it's visible which button is pressed, dmv 'active' class -->
                        <a class="dropdown-item" href="<?php echo "$generalURL&sort=0&limit=${limit}&page=${page}" ?>">Standaard</a>
                        <a class="dropdown-item" href="<?php echo "$generalURL&sort=1&limit=${limit}&page=${page}" ?>">Prijs oplopend</a>
                        <a class="dropdown-item" href="<?php echo "$generalURL&sort=2&limit=${limit}&page=${page}" ?>">Prijs aflopend</a>
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
                    <button class="btn active" onclick="gridView()"><i class="fa fa-th"></i> Grid</button>
                </div>
            </div>

            <?php
            if(empty($description)){
                echo  "Er zijn 0 resultaten.";}
            else {
                echo "Er zijn " . $nRows . " resultaten.";
            }
        ?>
        <div class="row" id="categorieen">
        <?php
        foreach($resultcat1 as $r){
            $stock_id = $r[0];
            $stock_name = $r[1];
            $stock_price = $r[2];
            ?>
            <div class="col-md-3 col-12 pb-2 product-box">
                <div class="card mb-4 text-center cart-content" >
                    <a href="/WideWorldImporters/single.php?ProductID=<?php echo $stock_id?>">
                        <img class="card-img" src="./images/<?php echo $stock_id . "-1.jpg"; ?>" alt="<?php echo $stock_name; ?>" onerror="this.src='/WideWorldImporters/images/placeholder.png';"/>
                    </a>
                    <div class="card-body text-center product-overview-info" style="margin-top: -160px!important;">
                        <p class="text-left card-text"><span style="float:left;"><?php echo $stock_name; ?></span></p><br>
                        <p class="text-left card-text"><span style="float:left;"><?php echo "Prijs: ".$stock_price; ?></span></p>
                        <p><?php echo $array[array_rand($array)]; ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
        </div>
    </div>
</div>

</body>

<?php
require_once 'footer.php';
?>

