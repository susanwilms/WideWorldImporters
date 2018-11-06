<?php
//test sessie
$_SESSION['_' . 43] = 2;
$_SESSION['_' . 23] = 20;
print_r($_SESSION);