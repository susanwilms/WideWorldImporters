<?php
session_start();

//test sessie met 5 verschillende items
//php vond het niet leuk wanneer een key alleen een getal als waarde had, daarom de underscores
$_SESSION['cart'] = array ('_43' => 2, '_23' => 1, '_13' => 10, '_3' => 5, '_123' => 1);
print_r($_SESSION);
print(count($_SESSION['cart']));
