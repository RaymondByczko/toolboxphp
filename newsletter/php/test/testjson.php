<?php
header('Content-Type: application/json');
$greatGuy = array(
	"name"=>"Abe Lincoln",
	"email"=>"Best president"
);
$clintEastwood = array(
	"name"=>"Blonde",
	"email"=>"good@goodbadugly.com"
);
$someGreats = array($greatGuy, $clintEastwood);
// echo json_encode($greatGuy);
echo json_encode($someGreats);
?>
