<?php
	// require_once('sharedsecret.inc');
	// ini_set('display_errors', '1');
	class CtlwebserviceLog
	{
		public function __construct()
		{
			openlog('cservice.php', LOG_NDELAY|LOG_PID, LOG_SYSLOG);
		}
		public function __destruct()
		{
			closelog();
		}
	}
	$objLogger = new CtlwebserviceLog();
	// ABOVE: CtlwebserviceLog - instantiate so we can closelog.

	$server = new SoapServer(null, array('uri'=>"http://ctlwebservice.dev/"));
	// adjustTableHeight: adjusts the table height from its absolute
	// zero (i.e. bottom) setting.  Units are either mm or inches.
	// Negative numbers are not allowed. randomrpcid is a random number
	// generated on the client side, sent to the server, to keep track
	// of what is happening in the logs.
	function adjustTableHeight($randomrpcid, $newHeight, $units)
	{
		syslog(LOG_INFO, 'adjustTableHeight-start:randomrpcid='.$randomrpcid);
		// Sanity check.
		if ($newHeight < 0)
		{
			// $server->fault("1", "adjustTableHeight:invalid-negative table height");
			syslog(LOG_ERR, 'adjustTableHeight-error-newHeight='.$newHeight.":randomrpcid=".$randomrpcid);
			return new SoapFault("1", "adjustTableHeight:invalid-negative table height:randomrpcid=".$randomrpcid);
		}
		// More sanity check.
		if ( !($units == 'mm')||($units == "inch") )
		{

			syslog(LOG_ERR, 'adjustTableHeight-error-units='.$units.":randomrpcid=".$randomrpcid);
			return new SoapFault("2", "adjustTableHeight: invalid units:randomrpcid=".$randomrpcid);
		}
		syslog(LOG_INFO, 'adjustTableHeight-end:randomrpcid='.$randomrpcid);
		return "adjustHeight:newHeight=".$newHeight.':status:success';
	}
	// rotateTable: rotates the table a certain angle, + or -.  The 
	// units parameter can be radians or degrees.  As per other methods
	// on this server, randomrpcid is used to denote the particular
	// invocation of the soap call - for log coordination.
	function rotateTable($randomrpcid, $angle, $units)
	{
		syslog(LOG_INFO, 'rotateTable-start:randomrpcid='.$randomrpcid);
		return 'rotateTable:status:success';
	}
	function testSOAP()
	{
		return "testSOAP:status:success";
	}
	$server->addFunction('testSOAP');
	$server->addFunction('adjustTableHeight');
	$server->addFunction('rotateTable');
	$server->handle();
	// echo "server=".$server;
	
?>
