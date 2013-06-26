<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file lesson05.php
  * @start_date 2013-06-25 June 25.
  * @purpose To learn more about php.  Specifically, array keys
  * are considered with and without single quotes, and the use
  * of constants (with define) as keys.
  * @status Nothing outstanding.  All results are as expected.
  * @important_point 1) Running 'php -l -f <file>' reveals syntax issues.
  * It is indicated with the shorthand of [1].
  * @important_point 2) A constant is ok as an index as long as it has
  * been define-d.  See section 1.
  * @important_point 3) Not bothering to define such a constant is explored
  * in section 2.
  * @important_point 4) The lack of defining a constant is explored when
  * that constant is used in a string and constants are not considered
  * in strings anyway.  See section 3 and its subsection 'a',
  */


echo '===== section 1 ====='."\n";
// error_reporting(E_ALL);
define('INDEXA', 'indexva');
$myarray1 = array(INDEXA=>'valuea', 'indexvb'=>'valueb');
// Note: the use of $my_array is not picked up by [1].
// var_dump($my_array1);
var_dump($myarray1);
// Conlusion at end of this section: INDEXA is alright to use as key
// without single quotes because of the define utilized before.
// For section 2, lets see what happens if define is not utilized.
echo '===== section 2 ====='."\n";
$myarray2 = array(indexc=>'valuec', 'indexd'=>'valued');
// The above generates:PHP Notice:  Use of undefined constant indexc - assumed 'indexc'
var_dump($myarray2);
echo '===== section 3 ====='."\n";
$myarray3 = array(indexe=>'valuee', 'indexf'=>'valuef');
echo 'section 3: substart a'."\n";
echo "...This is first element of myarray3: $myarray3[indexe]"."\n";
echo '...There should be no E_NOTICE here.'."\n";
echo '...This is because constants are not looked for in strings.'."\n";
echo 'section 3: subend a'."\n";
echo 'section 3: substart b'."\n";
echo '...This is first element of myarray3: '.$myarray3[indexe]."\n";
echo '...There should be a E_NOTICE here.'."\n";
echo 'section 3: subend b'."\n";

?>
