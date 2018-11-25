<?php

require_once 'connection.php';
require_once 'header.php';


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

    $stmt = $conn->prepare("SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems WHERE StockItemID in (:item1, :item2, :item3, :item4)");
    $stmt->bindParam(':item1', $item1);
    $stmt->bindParam(':item2', $item2);
    $stmt->bindParam(':item3', $item3);
    $stmt->bindParam(':item4', $item4);
    $stmt->execute();
    $result = $stmt->fetchAll();
    ?>

</p>
<div class="container">
    <div class="row" id="Categories">
        <?php
        if(!empty($result)){
            foreach($result as $r){
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
</div>

<?php
    require_once 'footer.php';
?>
