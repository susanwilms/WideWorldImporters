<?php
require_once 'connection.php';
require_once 'header.php';

##<--!All variables used in this document-->

$productgroup= (int)filter_input(INPUT_GET, "productgroup", FILTER_SANITIZE_STRING);
$sort= (int)filter_input(INPUT_GET, "sort", FILTER_SANITIZE_STRING);
$limit= (int) filter_input(INPUT_GET, "limit", FILTER_SANITIZE_STRING);
$page= (int) filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING);

$generalURL= "/WideWorldImporters/Categories.php?productgroup=". $productgroup;


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
$sort_options = array (0 => "sisg.StockItemID ASC", 1 => "UnitPrice ASC", 2 => "UnitPrice DESC");
$sorted = $sort_options[$sort];

##<----------------------------------------------->


##<-- SQL querry en connection configuration -->

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$stmtcat = $conn->prepare("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = :groupid ORDER BY ${sorted} LIMIT :page,:limit;");
$stmtcat->bindParam(':groupid', $productgroup);
$stmtcat->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmtcat->bindParam(':page', $pages, PDO::PARAM_INT);
$stmtcat->execute();
$resultcat1 = $stmtcat->fetchAll();

##Met deze querry tel je de aantal records van een group, dit gebruiken wij voor pagination
$nRows = $conn->query("SELECT sisg.StockItemID, si.StockItemName, si.UnitPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = $productgroup")->rowCount();
$aantalPages= $nRows/$limit;
$aantalPages=ceil($aantalPages); //Bepaal de aantal pages.



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
    <div class="container ">
        <!-- This is the category photo -->
        <img id="img_productgroup" src="/WideWorldImporters/images/productgroup<?php print($productgroup);?>.jpg">

        <!-- This is the different sorting element above the items -->
        <div id="test">

            <!--Pagination-->
            <?php


            ?>
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
                        Sorteer op:
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"></button>

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
