<?php
/**
	@company self
	@author Raymond Byczko
	@file processxlsimage.php
	@start_date 2013-02-18 Feb 18
	@purpose This file produces an image based on the file uploaded by the user
	in index.php .
	@status incomplete, rough, needs refinement
	@change_history  2013-02-28 Feb 28, RByczko, Able to displayed generated image.
	This is in line with 'thick' controller, 'thin' view. Let the controller
	do most of the processing.
	@change_history 2013-02-28 Feb 28, RByczko.  Clean up of this file.
*/
?>
<?php

	echo 'pifile='.$pifile;
	echo 'base_pifile='.$base_pifile;
	echo $this->Html->image('../../stored_images/'.$base_pifile);

	echo $this->Html->link('Logout here', array('controller'=>'users', 'action'=>'logout'));
	return;
	$debug = 0;
	if ($debug) { echo 'rdata=';};
	if ($debug) { pr($rdata);}
	if ($debug) { echo 'upload='.$upload; }
	if ($debug) { echo 'stored='.$stored; }

?>
