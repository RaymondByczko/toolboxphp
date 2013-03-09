<?php
// @company self
// @author Raymond Byczko
// @file navigation.ctp
// @purpose This is navigation element which puts site internal
// links in a single containing division.
// @change_log 2013-03-09 Feb 09, RByczko, Started this file.
// Will add this to git and further refine.  Status is accurate.
// @status working
?>

<?php echo $this->Html->css('navs'); ?>
<div style='position: relative'>
<div id=logout_id class=nav_entry style='position: absolute; top: 0px; left: 0px; height: 25px; width: 100px' >
<?php
	echo $this->Html->link('Logout', array('controller'=>'users', 'action'=>'logout'));
?>
</div>
<div id=upload_id class=nav_entry style='position: absolute; top: 0px; left: 112px; height: 25px; width: 100px' >
<?php
	echo $this->Html->link('Upload', array('controller'=>'graphs', 'action'=>'upload'));
?>
</div>
<div id=history_id class=nav_entry style='position: absolute; top: 0px; left: 224px; height: 25px; width: 100px' >
<?php
	echo $this->Html->link('History', array('controller'=>'graphs', 'action'=>'history'));
?>
</div>
