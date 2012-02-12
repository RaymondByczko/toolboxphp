<?php
/*
 * author: Raymond Byczko
 * date: 2012-02-12.
 * cclient.php: the purpose of this php code is to allow access to
 * a web service, on a local or remote server, and adjust the
 * height of a table.
 *
 * The following network transmissions are anticipated to occur.
 * A browser client makes a POST request to this page, supplying necessary
 * parameters to adjust a medical table's height.  The new height
 * is given along with the its units.
 *
 * cclient.php is invoked on the server.  It makes a call to the
 * Soap Server, which executes the code on its machine, and returns
 * a result. This result is recieved by cclient.php, which is 
 * then forwarded via XML back to the browser client.
 *
 */
	
	ini_set('display_errors', '1');

	$newTableHeight = null;
	$unitsTableHeight = null;
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		if (!array_key_exists('TABLE_HEIGHT', $_GET))
		{
		}
		if (!array_key_exists('UNITS', $_GET))
		{
		}
		$newTableHeight = $_GET['TABLE_HEIGHT'];
		$unitsTableHeight = $_GET['UNITS'];
	}
	$client = new SoapClient(null, array('location'=>"http://ctlwebservice.dev/cservice.php", 'uri'=>'http://ctlwebservice.dev', 'trace'=>1, 'exceptions'=>0));
	// randomIpcId: generates a random rpc id number used in logs on
	// both ends to facilitate multi-log coordination.
	$randomIpcId = mt_rand();
	// $ra = $client->__soapCall("adjustTableHeight", array("$randomIpcId",50, "mm"), array('soapaction'=>'adjustHeight2'));
	$ra = $client->__soapCall("adjustTableHeight", array("$randomIpcId",$newTableHeight, $unitsTableHeight), array('soapaction'=>'adjustTableHeight'));
	if (is_soap_fault($ra))
	{
		echo "soapfailed\n";
		$fc = $ra->faultcode;
		$fs = $ra->faultstring;
		// TODO: log to database
		echo "fc=$fc\n";
		echo "fs=$fs\n";
	}
	// echo 'ra='.$ra;
	// echo $ra;

	// echo "Response:\n" . $client->__getLastResponse() . "\n";

	header('Content-Type: text/xml');
	echo $client->__getLastResponse();
