<?php
/**
  *
  * @file index.php
  * @author Raymond Byczko
  * @purpose This page is the front end, the surface web page, of a site
  * that provides for uploading spreadsheets and having them displayed
  * through a php library.
  * @start_date 2013-02-18
  * @work_history 2013-02-18 Feb 18 Initial check-in of this file into git.
  * @status incomplete
  * @todo login, spread sheet particulars (does the data start with
  * the first row, or does the first row contain column headers?
  */
?>
<h1>Upload *.xls file here</h1>
<!--<form enctype="multipart/form-data" action="processXLSimage.php" method="POST">
  <input type="hidden" name="MAX_FILE_SIZE" value="100000">
  XLS File: <input name="xlsToProcess" type="file">
  <input type="submit" value="Upload">
</form>
-->
<?php echo $this->Form->create('Graph', array('action'=>'processxlsimage', 'type'=>'file', 'name'=>'xlstoprocess')); ?>
<?php // echo $this->Form->create('Graph', array('action'=>'processxlsimage', 'type'=>'file', 'name'=>'xlsToProcess')); ?>

<?php // echo $this->Form->input(null, array('type'=>'hidden', 'name'=>'MAX_FILE_SIZE', 'value'=>'100000')); ?>
<?php  //// echo $this->Form->input('xlstoprocess', array('type'=>'file', 'name'=>'xlsToProcess', 'value'=>'100000')); ?>

<?php  echo $this->Form->file('xlstoprocess'); ?>
<?php echo $this->Form->end('Upload'); ?>

<?php echo $this->Html->link('Logout here', array('controller'=>'users', 'action'=>'logout')); ?>
