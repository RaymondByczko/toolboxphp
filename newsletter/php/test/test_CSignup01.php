<?php
include_once('CSignup.php');
$objCS = new CSignup('POST','/test/signupaction.php');
$theIds = array();
$theIds['signupname']='SIGNUPN';
$theIds['signupemail']='SIGNUPE';
$objCS->setids($theIds);
?>
<html>
<head>
<?php
$objCS->style();
?>
</head>
<body>
<?php
echo '<pre>CSignup.php: start</pre>';
$objCS->display();
echo '<pre>CSignup.php: end</pre>';
?>
