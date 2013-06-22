<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file lesson02.php
  * @start_date 2013-06-22 June 22.
  * @purpose To learn more about php.  Specifically, how very large
  * ints beyond the bounds of int type are converted to float.
  * @status Nothing outstanding.  All results are as expected.
  */


echo '===== section 1 ====='."\n";
$myVeryLargeIntA = 2000000000000000000000001; // This is 2x10(24) + 1
var_dump($myVeryLargeIntA);
echo '===== section 2 ====='."\n";
$myVeryLargeIntB = 3000000000000000000000001; // This is 3x10(24) + 1
$myFloatB =  4e24;
$myFloatSumB = $myVeryLargeIntB + $myFloatB;
var_dump($myFloatSumB);
echo '===== section 3 ====='."\n";
$myVeryLargeIntC = 5090000000000000000000001; // This is 5.09x10(24) + 1
$myFloatC =  2e24;
$myFloatSumC = $myVeryLargeIntC + $myFloatC;
var_dump($myFloatSumC);
echo '===== section 4 ====='."\n";
$myVeryLargeIntD = 1091000000000000000000001; // This is 1.091x10(24) + 1
$myVeryLargeIntE = 1003000000000000000000001; // This is 1.003x10(24) + 1
$myFloatSumE = $myVeryLargeIntD + $myVeryLargeIntE;
var_dump($myFloatSumE);
