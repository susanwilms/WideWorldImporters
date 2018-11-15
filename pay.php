<?php

require_once('header.php');
include ('connection.php');

$ingelogd= FALSE;
?>
<style>
    .outer {
        display: table;
        position: absolute;
        height: 100%;
        width: 100%;
    }

    .middle {
        display: table-cell;
        vertical-align: middle;
    }

    .inner {
        margin-left: auto;
        margin-right: auto;
        width: 800px;
        height: 400px;
        box-shadow: 3px 4px 6px rgba(0, 0, 0,0.5);
        background-color: #ebebeb;
    }

    .inner #cellen{
        /*background-color: red;*/
        margin-right: auto;
        width: 400px;
        height: 400px;


    }
    .inner #cellen:first-child{
        /*background-color: blue;*/
        margin-right: auto;
        width: 400px;
        height: 400px;
        float: right;
        border-left: 1px solid grey;


    }
    #cellen h2{
        padding-top: 5%;
        text-align: center;
    }
    #cellen button{
        height:40px;
        width:200px;
        margin: -40px -100px;
        position:relative;
        left:50%;
        top: 20%;
    }
</style>


<div class="outer">
    <div class="middle">
        <div class="inner">
            <div id="cellen">
                <h2>Inloggen</h2>

                <?php
                if($ingelogd==TRUE){

                ?>
                    <button type="button" class="btn btn-info">Verder met mijn account</button>

                <?php
                }else {
                    ?>
                    <button type="button" class="btn btn-info">INLOGGEN</button>

                    <?php
                }
                ?>
            </div>
            <div id="cellen">
                <h2>Afrekenen als gast</h2>
                <p></p>

                <form >


                </form>
            </div>

        </div>
    </div>
</div>
