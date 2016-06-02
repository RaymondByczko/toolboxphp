<?php
include 'Flatten.php';

$objF = new Flatten();
$arr1D_A = array(5,10,15);
$arr1D_B = array(2,4,6, $arr1D_A);
$retIt = $objF->it($arr1D_B);
print_r($retIt);
?> 
