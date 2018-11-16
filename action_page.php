<?php
/**
 * Created by PhpStorm.
 * User: susanwilms
 * Date: 13/11/2018
 * Time: 14:08
 */


require_once('header.php');
include ('connection.php');

##<!-- Random generated reviews -->
$driester = "<span>★</span><span>★</span><span>★</span><span>☆</span><span>☆</span>";
$vierster = "<span>★</span><span>★</span><span>★</span><span>★</span><span>☆</span>";
$vijfster = "<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>";

$array = array($driester, $vierster, $vijfster);
##<!-- End reviews -->
##<!-- Search bar input -->
$description = filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING);
?>
<!-- Style for page -->
<style xmlns="http://www.w3.org/1999/html">

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

    #lol {

    }

</style>
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

<div id="main_container">
    <div class="container pt-4">

        <!-- This is the different sorting element above the items -->
        <div id="test">
            <div id="Element">
                Pagina  << < 1 van 2 > >>
            </div>
            <div id="Element">
                Sorteert op:
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">

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


            <div id="Element">
                Aantal:
                <div class="btn-group">
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
            <div id="Element">
                <button class="btn" onclick="listView()"><i class="fa fa-bars"></i> List</button>
                <button class="btn active" onclick="gridView()"><i class="fa fa-th"></i> Grid</button>
            </div>

        </div>
<?php
$stmtcat1 = $conn->prepare('SELECT * FROM stockitems WHERE SearchDetails LIKE "%' . $description . '%"');

$stmtcat1->bindParam(':groupid', $groupid);
$stmtcat1->bindParam(':sort', $sort);
$stmtcat1->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmtcat1->execute();
$resultcat1 = $stmtcat1->fetchAll();
$aantalpr = count($resultcat1);
?>
        <?php
        if(empty($description)){
            echo  "Er zijn 0 resultaten.";}
        else {
            echo "Er zijn " . $aantalpr . " resultaten.";
        }
        ?>
<div class="row" id="categorieen">

    <?php
    if(empty($description)){
        echo  " ";}
        else{
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
        <?php }}
        }?>

</div>
