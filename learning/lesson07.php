<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file lesson07.php
  * @start_date 2013-06-27 June 27.
  * @purpose To learn more about php.  Specifically, arrays and
  * the use of unset and array_values are considered.
  * @status Nothing outstanding.  All results are as expected.
  * @important_point 1) Running 'php -l -f <file>' reveals syntax issues.
  * It is indicated with the shorthand of [1].
  * @important_point 2)
  * @important_point 3)
  */
echo '===== section 1 ====='."\n";
// Normal way to create an array.
$myarray1 = array('shape'=>'square', 'fruit'=>'apple', 0=>14, 1=>15);
var_dump($myarray1);
echo '===== section 2 ====='."\n";
// Now try without the array initialization syntax as above.
$myarray2['fuel']='gas';
$myarray2['vegetable'] ='carrot';
$myarray2[0]=18;
$myarray2[1]=19;
var_dump($myarray2);
echo '===== section 3 ====='."\n";
// Now skip the keys and just use an empty bracket.
$myarray3[] = 'orange';
$myarray3[] = 'kiwi';
$myarray3[] = 'cherry';
var_dump($myarray3);
echo '===== section 4 ====='."\n";
// Now try unset to remove an element from an array.
$myarray4 = array('tree'=>'oak', 'meat'=>'fish', 12=>'dozen', 1=>'theonlyone');
echo '... before unset'."\n";
var_dump($myarray4);
unset($myarray4[12]);
echo '... after unset'."\n";
var_dump($myarray4);
$myarray4[]='somethingnew';
echo '... after adding a new element'."\n";
var_dump($myarray4);
echo '===== section 5 ====='."\n";
// Now try unset on multiple elements and try array_values.
$myarray5 = array(0=>'cat', 1=>'dog', 2=>'bird', 3=>'mouse', 4=>'eagle', 5=>'hawk');
echo 'initial state'."\n";
var_dump($myarray5);
unset($myarray5[5]);
unset($myarray5[4]);
echo 'after removing keys 4, 5'."\n";
var_dump($myarray5);
$myarray5[]='chicken';
echo 'after adding chicken'."\n";
var_dump($myarray5);
$myarray5b = array_values($myarray5);
echo 'after reindexing with array_values'."\n";
echo '... myarray5'."\n";
var_dump($myarray5);
echo '... myarray5b'."\n";
var_dump($myarray5b);
// Note: array_values produces a new reindexed array.
// It does not change the one given to it.
echo '===== section 6 ====='."\n";
// Now try to unset an element that does not exist.
$myarray6 = array(0=>'apple juice', 1=>'grape juice', 2=>'water');
echo 'initial state of myarray6'."\n";
var_dump($myarray6);
echo '... before unset'."\n";
unset($myarray6[7]);
echo '... after unset'."\n";
echo 'current state of myarray6'."\n";
var_dump($myarray6);
$myarray6[] = 'milk';
$myarray6[] = 'beer';
$myarray6[] = 'hot cocoa';
echo 'state of myarray6 after adding three more elements'."\n";
var_dump($myarray6);
?>
