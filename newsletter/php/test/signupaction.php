<?php
/*
 * @file newsletter/php/test/signupaction.php
 * @company self
 * @author Raymond Byczko
 * @start_date 2016-02-28 Feb 28, 2016
 * @purpose A used to process a form for signup.
 * @change_history 2016-02-28, RByczko, Started this file.
 * @change_history 2016-03-01, RByczko, Corrected spelling
 * for email.
 */
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	include_once('CSignup.php');
	$objCS = new CSignup('POST','test/signupaction.php');
	$fn = $objCS->getFormNames();
	var_dump($fn);
	if (1)
	{
	$name = $_POST[$fn[0]];
	$email = $_POST[$fn[1]];
	echo $name."\n";
	echo $email."\n";
	}
}
?>
