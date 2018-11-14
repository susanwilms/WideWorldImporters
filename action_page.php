<?php
/**
 * Created by PhpStorm.
 * User: susanwilms
 * Date: 13/11/2018
 * Time: 14:08
 */


require_once('header.php');
include ('connection.php');

$driester = "<span>★</span><span>★</span><span>★</span><span>☆</span><span>☆</span>";
$vierster = "<span>★</span><span>★</span><span>★</span><span>★</span><span>☆</span>";
$vijfster = "<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>";

$array = array($driester, $vierster, $vijfster);

$description = filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING);
?>
<style>
    p{
        margin-top: 5%;
        text-align: center;

    }

    p{
        display: inline-block;
        margin-left: 3%;
    }

</style>
<p><?php print($description); ?></p>

<?php
$stmtcat1 = $conn->prepare('SELECT * FROM stockitems WHERE SearchDetails LIKE "%' . $description . '%"');

$stmtcat1->bindParam(':groupid', $groupid);
$stmtcat1->bindParam(':sort', $sort);
$stmtcat1->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmtcat1->execute();
$resultcat1 = $stmtcat1->fetchAll();
##$select->execute();
##$result = $select->fetchAll();

##$productName =      $result[0]["StockItemName"];
##$productPrice =     $result[0]["RecommendedRetailPrice"];

?>

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

