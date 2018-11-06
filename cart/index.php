<?php

require_once '../connection.php';
require_once '../header.php';

//test sessie
$_SESSION['_' . 43] = 2;
$_SESSION['_' . 23] = 20;
print_r($_SESSION);

?>


<div class="container pt-5 col-md-10">
    <h2 class="py-3">Je winkelmand</h2>

    <?php
    foreach ($_SESSION as $id => $aantal) {
        $id2 = substr($id, 1);
        ?>
        <div class="row py-2" style="">
            <div class="col-md-2">
                <img src="https://www.bbqenzo.nl/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/d/r/drank-alcohol-vrij-bier.jpg" class="img-thumbnail" alt="Plaatje"
                     width="100" height="100">
            </div>
            <div class="col-md-7">
                <h5><?php echo $result[$id2]['StockItemName']?></h5>


                    <p>Math.floor(Math.random() * 100)) returns a random integer between 0 and 99
                        (both included):</p>

                    <p id="demo"></p>

                    <script>
                        document.getElementById("demo").innerHTML =
                            Math.floor(Math.random() * 100);
                    </script> Op voorraad.</h6>

            </div>
            <div class="col-md-3">
                <h8>Aantal:</h8> <input type="number" value="<?php echo $_SESSION[$id]?>">
            </div>

        </div>
        <?php
    }
    ?>



</div>


<?php
require_once '../footer.php';
?>