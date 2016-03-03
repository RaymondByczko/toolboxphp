<?php
/*
 * @file newsletter/php/test/test_CSignup01.php
 * @company self
 * @author Raymond Byczko
 * @start_date 2016-02-27 Feb 27, 2016(approx)
 * @purpose A test page used to test the php class
 * CSignup.php.
 * @change_history 2016-03-01, RByczko, Added validation.
 * @change_history 2016-03-03, RByczko, Added doctype and
 * other html parts.
 */
?>
<?php
// First, include the class file.
include_once('CSignup.php');
// Second, instantiate the class providing the method and action.
$objCS = new CSignup('POST','/test/signupaction.php');
// Third, set up which IDs to use in the DOM.
$theIds = array();
$theIds['signupname']='ID_SIGNUPN';
$theIds['signupemail']='ID_SIGNUPE';
$theIds['form']='ID_SIGNUPF';
$objCS->setids($theIds);
// Fourth, set the validation flag.
$objCS->validation(TRUE);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php
$objCS->style();
?>
</head>
<body>
<?php
$objCS->script();
?>
<?php
echo '<pre>test_CSignup01.php: start</pre>';
echo '<hr></hr>';
$objCS->display();
echo '<hr></hr>';
echo '<pre>test_CSignup01.php: end</pre>';
?>
