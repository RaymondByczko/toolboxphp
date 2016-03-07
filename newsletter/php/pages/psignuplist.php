<?php
/*
 * @file newsletter/php/pages/psignuplist.php
 * @company self
 * @author Raymond Byczko
 * @start_date 2016-03-07 March 7, 2017
 * @purpose A page used to output a signup table
 * using a javascript library, handsontable.
 * @change_history 2016-03-07, RByczko, Started this file.
 * @note This file is derived from: php/test/signuplist.php
 */
?>
<!DOCTYPE html>
<html lang="en-US">
<html>
<head>
<script src="/bower_components/handsontable/dist/handsontable.full.js"></script>
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<link rel="stylesheet" media="screen" href="/bower_components/handsontable/dist/handsontable.full.css">
</head>
<body>
<pre>psignuplist.php: start</pre>
<div id="signuplist">
</div>
<div id="ID_JTRIGGER">
Click here J
</div>
<button id="ID_GET_LIST">Get Signuplist</button>
<script>
// $( "#ID_JTRIGGER" ).click(function() {
var hot;
$( "#ID_GET_LIST" ).click(function() {
	jQuery.getJSON("/test/testdbjson.php", function(data)
	{
		console.log(data);
		// var hot;
		// hot = null;
		if (hot != null)
		{
			// hot.clear();
			hot.destroy();
		}
		var container = document.getElementById('signuplist');
		hot = new Handsontable(container, {
		  data: data,
		  rowHeaders: true,
		  colHeaders: true
		});
	} );
});
</script>
<pre>psignuplist.php: end</pre>
</body>
</html>
