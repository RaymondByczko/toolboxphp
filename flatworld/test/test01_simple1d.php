<?php
include 'Flatten.php';

$objF = new Flatten();
$arr1D = array(5,10,15);
$retIt = $objF->it($arr1D);
print_r($retIt);
?> 
