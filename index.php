<?php
require_once 'connection.php';
require_once 'header.php';

// all variables used in this document
$productgroup = (int)filter_input(INPUT_GET, "productgroup", FILTER_SANITIZE_STRING);
$sort = (int)filter_input(INPUT_GET, "sort", FILTER_SANITIZE_STRING);
$limit = (int) filter_input(INPUT_GET, "limit", FILTER_SANITIZE_STRING);
$page = (int) filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING);

$generalURL = "/WideWorldImporters/Categories.php?productgroup=". $productgroup;

// array with all possible sort options
$sort_options = array (0 => "sisg.StockItemID ASC", 1 => "RecommendedRetailPrice ASC", 2 => "RecommendedRetailPrice DESC");
$sorted = $sort_options[$sort];

// QUERY 1, for getting the itemID, Name, and price.
$stmtcat = $conn->prepare("SELECT sisg.StockItemID, si.StockItemName, si.RecommendedRetailPrice FROM stockitemstockgroups sisg JOIN stockitems si ON sisg.StockItemID=si.StockItemID WHERE StockGroupID = :groupid ORDER BY ${sorted} LIMIT :page,:limit;");
$stmtcat->bindParam(':groupid', $productgroup);
$stmtcat->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmtcat->bindParam(':page', $pages, PDO::PARAM_INT);
$stmtcat->execute();
$resultcat1 = $stmtcat->fetchAll();

// generation of random review stars
$threestar = "<span>★</span><span>★</span><span>★</span><span>☆</span><span>☆</span>";
$fourstar = "<span>★</span><span>★</span><span>★</span><span>★</span><span>☆</span>";
$fivestar = "<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>";

$array = array($threestar, $fourstar, $fivestar);

?>
<img id="img_productgroup" src="./images/header.jpg">
<p><?php
    $item1 = rand(1, 227);
    do {
        $item2 = rand(1,227);
    } while ($item1 == $item2);
    do {
        $item3 = rand(1, 227);
    } while ($item1 == $item3 or $item2 == $item3);
    do {
        $item4 = rand(1, 227);
    } while ($item1 == $item4 or $item2 == $item4 or $item3 == $item4);

    $stmtcat2 = $conn->prepare("SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems WHERE StockItemID = :item1 or StockItemID = :item2 or StockItemID = :item3 or StockItemID = :item4");
    $stmtcat2->bindParam(':item1', $item1);
    $stmtcat2->bindParam(':item2', $item2);
    $stmtcat2->bindParam(':item3', $item3);
    $stmtcat2->bindParam(':item4', $item4);
    $stmtcat2->execute();
    $resultcat2 = $stmtcat2->fetchAll();
    ?>

</p>

<div class="row" id="Categories">

    <?php
    if(!empty($resultcat2)){
        foreach($resultcat2 as $r){
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
        <?php } }
        ?>
</div>
<?php
    require_once 'footer.php';
?>
</body>
