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
</div>
