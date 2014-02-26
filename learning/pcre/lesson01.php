<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file pcre/lesson01.php
  * @start_date 2013-08-15 August 15.
  * @purpose To learn more about php. Specifically how PCRE can
  * be effectively used in regular expressions.
  * @status Nothing outstanding.  All results are as expected.
  */

echo '===== section 1 ====='."\n";
$line1 = '1234567890';
$matches1 = array();
$retpm1 = preg_match('^12345', $line1, $matches1); 
echo 'retpm1='.$retpm1."\n";
echo 'print_r of retpm1 (start)'."\n";
print_r($retpm1); echo "\n";
echo 'print_r of retpm1 (end)'."\n";
echo 'line1='.$line1."\n";
print_r($matches1);


echo '===== section 2 ====='."\n";
$line2 = '1234567890';
$matches2 = array();
$retpm2 = preg_match('/^12345/', $line2, $matches2); 
echo 'retpm2='.$retpm2."\n";
echo 'print_r of retpm2 (start)'."\n";
print_r($retpm2); echo "\n";
echo 'print_r of retpm2 (end)'."\n";
echo 'line2='.$line2."\n";
print_r($matches2);


echo '===== section 3 ====='."\n";
$line3 = 'ABCiiiiiDEFkkkkk';
$matches3 = array();
$retpm3 = preg_match('/ABC.*DEF/', $line3, $matches3); 
echo 'retpm3='.$retpm3."\n";
echo 'print_r of retpm3 (start)'."\n";
print_r($retpm3); echo "\n";
echo 'print_r of retpm3 (end)'."\n";
echo 'line3='.$line3."\n";
print_r($matches3);


echo '===== section 4 ====='."\n";
$line4 = 'ABCDEFkkkkk';
$matches4 = array();
$retpm4 = preg_match('/ABC.*DEF/', $line4, $matches4); 
echo 'retpm4='.$retpm4."\n";
echo 'print_r of retpm4 (start)'."\n";
print_r($retpm4); echo "\n";
echo 'print_r of retpm4 (end)'."\n";
echo 'line4='.$line4."\n";
print_r($matches4);


echo '===== section 5 ====='."\n";
$line5 = 'n1234567890';
$matches5 = array();
$retpm5 = preg_match('/^12345/', $line5, $matches5); 
echo 'retpm5='.$retpm5."\n";
echo 'print_r of retpm5 (start)'."\n";
print_r($retpm5); echo "\n";
echo 'print_r of retpm5 (end)'."\n";
echo 'line5='.$line5."\n";
print_r($matches5);

?>
