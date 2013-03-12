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
  * @work_history 2013-03-04 Mar 4 Adjust columnheadings associative array
  * to account for start row in spreadsheet. Added columnusage input.
  * @work_history 2013-03-11 Mar 11 Added graph type.
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
<?php echo $this->Form->create('Graph', array('action'=>'processxlsimage', 'type'=>'file', 'name'=>'xlstoprocess', 'label'=>'XLS2 file:')); ?>

<?php // echo $this->Form->create('Graph', array('action'=>'processxlsimage', )); ?>
<?php  echo $this->Form->file('xlstoprocess', array('label'=>'XLS file:')); ?>
<?php echo $this->Form->input('columnheading', array('options'=>array('notpresent'=>'No Present','row1'=>'Row 1','row2'=>'Row 2'), 'label'=>'Column Heading Location')); ?>
<?php echo $this->Form->input('columnusage', array('options'=>array('alabel_bdata'=>'Col. A label','adata_blabel'=>'Col. B label'), 'label'=>'Column Usage')); ?>
<?php echo $this->Form->input('graphtype', array('options'=>array('piechart'=>'Pie chart','bargraph'=>'Bar graph'), 'label'=>'Type of graph')); ?>
<?php echo $this->Form->end('Upload'); ?>


<?php echo $this->Html->link('Logout here', array('controller'=>'users', 'action'=>'logout')); ?>
