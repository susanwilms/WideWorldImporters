<?php

require_once('header.php');
include ('connection.php');

$ingelogd= FALSE;
?>
<style>
    .outer {
        display: table;
        position: absolute;
        height: 80%;
        width: 100%;
    }

    .middle {
        display: table-cell;
        vertical-align: middle;
    }

    .inner {
        margin-left: auto;
        margin-right: auto;
        margin-top: -10px;
        width: 80%;
        height: 100%;
        box-shadow: 3px 4px 6px rgba(0, 0, 0,0.5);
        background-color: #ebebeb;
    }

    .inner #cellen{
        /*background-color: red;*/
        margin-right: auto;
        width: 65%;
        height: 100%;
        padding: 2%;
        padding-top: 1%;

    }
    .inner #cellen:first-child{
        /*background-color: blue;*/
        margin-right: auto;
        width: 35%;
        height: 100%;
        float: right;
        border-left: 1px solid grey;
    }

    #cellen h2{
        /*padding-top: 5%;*/
        text-align: center;
    }

    #cellen:first-child button{
        height:40px;
        width:200px;
        margin: -40px -100px;
        position:relative;
        left:50%;
        margin-top: 20%;
    }
    #Gast_formulier .form-group{
        margin-bottom:0rem;
    }

    #buttomSubmit{
        top: 10px;
        /*lef: 20px;*/
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


                <div class="container">
                    <table class="table table-striped">

                                <form class="well form-horizontal" method="post" action="afrekenen.php">
                                    <fieldset id="Gast_formulier">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Volledige Naam</label>
                                            <div class="col-md-8 inputGroupContainer">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="fullName" name="fullName" placeholder="Voornaam Achternaam" class="form-control" required="true" value="" type="text"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Adres</label>
                                            <div class="form-inline">
                                                <div class="col-md-4 inputGroupContainer">
                                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine1" name="address" placeholder="Straat Huisnummer" class="form-control" required="true" value="" type="text"></div>
                                                </div>
                                                <div class="col-md-4 inputGroupContainer">
                                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postcode" name="postcode" placeholder="Postal Code/ZIP" class="form-control" required="true" value="" type="text"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Stad</label>
                                            <div class="col-md-8 inputGroupContainer">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="city" name="city" placeholder="Stad" class="form-control" required="true" value="" type="text"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Land</label>
                                            <div class="col-md-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <select class="selectpicker form-control">
                                                        <option>Nederland</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Email</label>
                                            <div class="col-md-8 inputGroupContainer">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="email" name="email" placeholder="Email" class="form-control" required="true" value="" type="text"></div>
                                            </div>
                                        </div>
                                        <div class="form-group" >
                                            <label class="col-md-4 control-label">Phone Number</label>
                                            <div class="col-md-8 inputGroupContainer">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span><input id="phoneNumber" name="phoneNumber" placeholder="Phone Number" class="form-control" required="true" value="" type="text"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col-md-4 control-label" id="buttomSubmit">
                                                <button type="submit" class="btn btn-info">Verzenden</button>
                                            </div>
                                        </div>

                                    </fieldset>
                                </form>
                    </table>


                </div>

            </div>

        </div>
    </div>
</div>
