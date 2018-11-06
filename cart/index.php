<?php

require_once '../connection.php';
require_once '../header.php';
require_once '../footer.php';
?>


<div class="container pt-4 col-md-10">
    <p>Producten:</p>

    <div class="row" style="">
        <div class="col-md-2">
            <img src="https://www.bbqenzo.nl/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/d/r/drank-alcohol-vrij-bier.jpg" class="img-thumbnail" alt="Plaatje"
                  width="100" height="100">
        </div>
        <div class="col-md-4">
             <h4>Naam van het product</h4>
            <h7>*aantal* Op voorraad.</h7>

        </div>
        <div class="col-md-4">
            <h8> Aantal:</h8> <input type="number" value="6">
        </div>

    </div>

</div>


<?php
require_once '../footer.php';
?>