<?php
/*
 * RByczko - self - This is a test harness for the TableUtility
 * class.  The database connection parameters are in testattribtues.php.
 */
	ini_set('display_errors', 'stdout');
	require_once('../changeutil.php');
	require_once('./testattributes.php');

	$tuObj = new TableUtility();
	$taObj = new TestAttributes();
	$tuObj->setInformation($taObj);
	$retGBF = $tuObj->getBasicFormat();
	echo "retGBF=".$retGBF."\n";
	$retGBCDT = $tuObj->getBasicColumnDataType();
	echo "retGBCDT=".$retGBCDT."\n";
?>
