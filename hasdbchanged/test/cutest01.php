<?php
	ini_set('display_errors', 'stdout');
	require_once('../changeutil.php');
	require_once('./testattributes.php');

	$tuObj = new TableUtility();
	$taObj = new TestAttributes();
	$tuObj->setInformation($taObj);
	$retGBF = $tuObj->getBasicFormat();
	echo "retGBF=".$retGBF."\n";
?>
