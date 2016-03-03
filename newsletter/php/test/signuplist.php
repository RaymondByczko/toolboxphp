<?php
/*
 * @file newsletter/php/test/signuplist.php
 * @company self
 * @author Raymond Byczko
 * @start_date 2016-03-03 March 3, 2016
 * @purpose A test page used to output a signup table
 * using a javascript library, handsontable.
 * @change_history 2016-03-03, RByczko, Started this file.
 */
?>
<!DOCTYPE html>
<html lang="en-US">
<html>
<head>
<script src="/bower_components/handsontable/dist/handsontable.full.js"></script>
<link rel="stylesheet" media="screen" href="/bower_components/handsontable/dist/handsontable.full.css">
</head>
<body>
<pre>signuplist.php: start</pre>
<div id="signuplist">
</div>
<script>
var data = [
  ["Name", "Email"],
  ["Richard Nixon", "rnixon@greatamericans.com"],
  ["Abe Lincoln", "alincoln@greatamericans.com"],
  ["Neil Armstrong", "iwalkedonmoon@greatamericans.com"]
];

var container = document.getElementById('signuplist');
var hot = new Handsontable(container, {
  data: data,
  rowHeaders: true,
  colHeaders: true
});
</script>
<pre>signuplist.php: end</pre>
</body>
</html>
