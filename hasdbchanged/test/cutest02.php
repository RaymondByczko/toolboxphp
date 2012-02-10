<?php
/*
 * RByczko - self - This is a test harness for the SchemaUtility
 * class.  The database connection parameters are in testattribtues.php.
 */
	ini_set('display_errors', 'stdout');
	require_once('../changeutil.php');
	require_once('./testattributes.php');

	$suObj = new SchemaUtility();
	$taObj = new TestAttributes();
	$suObj->setInformation($taObj);
	$retGT = $suObj->getTables("mycrm");
	echo "retGT=".$retGT."\n";
?>
