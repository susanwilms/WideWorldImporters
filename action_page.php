<?php

require_once('header.php');
include ('connection.php');

##<!-- Random generated reviews -->
$threestar = "<span>★</span><span>★</span><span>★</span><span>☆</span><span>☆</span>";
$fourstar = "<span>★</span><span>★</span><span>★</span><span>★</span><span>☆</span>";
$fivestar = "<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>";

$array = array($threestar, $fourstar, $fivestar);
##<!-- End reviews -->
##<!-- Search bar input -->
$sort= (int)filter_input(INPUT_GET, "sort", FILTER_SANITIZE_STRING);
$limit= (int) filter_input(INPUT_GET, "limit", FILTER_SANITIZE_STRING);
$page= (int) filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING);

$description = filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING);
$generalURL= "/WideWorldImporters/action_page.php?search=". $description;


// zet limit standaard op 24, de default waarde
if(empty($limit)){
    $limit=24;
}

// zet sorteer standaard op 0 wanneer deze niet geset is (de default sort dus)
if(empty($sort)){
    $sort = 0;
}

// Standard moet page 0, ook moet page 0 zijn wanneer ze op page 1 drukken.
if(empty($page) || $page==1){
    $pages=0;
}else{
    $pages=($page*$limit)-$limit; //Algorithme om de eerste cijfer van de limit te bepalen.
}

// array met alle mogelijke sorteer opties
$sort_options = array (0 => "si.StockItemID ASC", 1 => "UnitPrice ASC", 2 => "UnitPrice DESC");
$sorted = $sort_options[$sort];

$stmtcat1 = $conn->prepare("SELECT si.StockItemID, si.StockItemName, si.RecommendedRetailPrice FROM stockitems si WHERE si.SearchDetails LIKE '%${description}%' ORDER BY ${sorted} LIMIT :page,:limit;");

$stmtcat1->bindParam(':page', $pages, PDO::PARAM_INT);
$stmtcat1->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmtcat1->execute();
$resultcat1 = $stmtcat1->fetchAll();

##Met deze querry tel je de aantal records van een group, dit gebruiken wij voor pagination
$nRows = $conn->query("SELECT si.StockItemID, si.StockItemName, si.RecommendedRetailPrice FROM stockitems si WHERE si.SearchDetails LIKE '%${description}%'")->rowCount();
$aantalPages= $nRows/$limit;
$aantalPages=ceil($aantalPages); //Bepaal de aantal pages.

$aantalpr = count($resultcat1);
$conn = NULL;

?>
<!-- Script for list or grid view -->
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
                    Sorteert op:
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">

                    </button>
                    <div class="dropdown-menu">
                        <!-- TODO: zorgen dat er zichtbaar is welke button aangeklikt is, dmv 'active' class -->
                        <a class="dropdown-item" href="<?php echo "$generalURL&sort=0&limit=${limit}&page=${page}" ?>">Standaard</a>
                        <a class="dropdown-item" href="<?php echo "$generalURL&sort=1&limit=${limit}&page=${page}" ?>">Prijs oplopend</a>
                        <a class="dropdown-item" href="<?php echo "$generalURL&sort=2&limit=${limit}&page=${page}" ?>">Prijs aflopend</a>
                    </div>
                </div>

                <div id="Element">
                    Aantal:
                    <div class="btn-group">
                        <!-- TODO: zorgen dat er zichtbaar is welke button aangeklikt is, dmv 'active' class -->
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
            <?php
        }
    }
    ?>
        </div>
    </div>
</div>


