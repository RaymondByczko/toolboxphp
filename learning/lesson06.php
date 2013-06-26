<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file lesson06.php
  * @start_date 2013-06-25 June 25.
  * @purpose To learn more about php.  Specifically, array keys
  * are considered with and without single quotes, and the use
  * of constants (with define) as keys, all in the context of
  * curly brackets.  Also, this lesson explores how key casting is
  * done for arrays.
  * @status Nothing outstanding.  All results are as expected.
  * @important_point 1) Running 'php -l -f <file>' reveals syntax issues.
  * It is indicated with the shorthand of [1].
  * @important_point 2) A curly bracket pair in a double quote strings
  * will consider constants.  See section 1.
  * @important_point 3) No curly bracket pair in a double quote strings
  * will insure constants are ignored.
  * @important_point 4) A function can be used to produce a key value.
  * See section 2.
  * @important_point 5)
  */


echo '===== section 1 ====='."\n";
define('INDEXA', 'indexva');
$myarray1 = array(INDEXA=>'valuea', 'indexvb'=>'valueb', 'INDEXA'=>'theother');
print "first element (no bracket): $myarray1[INDEXA]"."\n";
print "... no curly brackets; constants are not looked for and\n";
print "... no need to single quote key per say.\n";
print "first element (bracket): {$myarray1[INDEXA]}"."\n";
print "... curly brackets within strings allow constants to be interpreted\n";
var_dump($myarray1);
// Conlusion at end of this section: The power of brackets to force
// scanning for constants or the lack of brackets to not scan for
// constant is illustrated here.
//
// An array element can be utilized in a bracket or bracketless env.
// The key for that can be presented as a constant, in a sense, and
// as a string value.  Both utilizations can be separately
// accounted for by adding the two keys: INDEXA, 'INDEXA'.  Interesting.
// This may be a useful redudancy in passing an array around in
// many client positions where each client may be calling
// the array element in different ways.
echo '===== section 2 ====='."\n";
$myarray2 = array('tree'=>'oak', 'fruit'=>'apple', 'animal'=>'dog');
var_dump($myarray2);
function producekey()
{
	return 'fruit';
}
echo 'The return of producekey is: '.producekey()."\n";
echo '$myarray2[producekey()] is: '.$myarray2[producekey()]."\n";
echo '===== section 3 ====='."\n";
$myarray3 = array(1=>'onevalue', '2'=>'twovalue', 3.333=>'threept333value');
var_dump($myarray3);
echo '===== section 4 ====='."\n";
$myarray4 = array(1=>'onevalue', '2aa'=>'twoaavalue', 3.333=>'threept333value');
var_dump($myarray4);
?>
