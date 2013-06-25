<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file lesson02.php
  * @start_date 2013-06-22 June 22.
  * @change_history 2013-06-24 June 24.  Checked out type juggling issues,
  * comparison using == vs ===, and casting.
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
echo '===== section 5 ====='."\n";
$myVeryLargeIntF = 1003000000000000000000001; // This is 1.003x10(24) + 1
$myVeryLargeFloatF = 1.003e24;
if ($myVeryLargeIntF == $myVeryLargeFloatF)
{
	echo 'Expected; the two are equal after type juggling'."\n";	
}
else
{
	echo 'Unexpected; the two are not equal after type juggling.'."\n";
}
if ($myVeryLargeIntF === $myVeryLargeFloatF)
{
	echo 'Unexpected; the two are equal and are of same type, which is not correct'."\n";	
}
else
{
	echo 'Expected; the two are not equal - they are of different types.'."\n";
}
echo '===== section 6 ====='."\n";
$six='6';
$numbersix = 6;
$tsix = gettype($six);
$tnumbersix = gettype($numbersix);
echo 'gettype of six is: '.$tsix."\n";
echo 'gettype of number6 is: '.$tnumbersix."\n";
if ($six == $numbersix)
{
	echo 'six and numbersix are equal after type juggling'."\n";
}
else
{
	echo 'six and numbersix are not equal after type juggling'."\n";
}
if ($six === $numbersix)
{
	echo 'six and numbersix are of the same type'."\n";
}
else
{
	echo 'six and numbersix are not of the same type'."\n";
}
if ((integer)$six === $numbersix)
{
	echo '(integer)six and numbersix are of the same type'."\n";
}
else
{
	echo '(integer)six and numbersix are not of the same type'."\n";
}
echo '===== section 7 ====='."\n";
$five='5';
$numbersix = 6;
$tfive = gettype($five);
$tnumbersix = gettype($numbersix);
if ((integer)$five === $numbersix)
{
	echo '(integer)five and numbersix are of the same type'."\n";
}
else
{
	echo '(integer)five and numbersix are not of the same type'."\n";
}
