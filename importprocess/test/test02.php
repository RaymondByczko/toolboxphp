<?php
/**
  * @file test/test02.php
  * @company self
  * @author Raymond Byczko
  * @purpose To provide a test harness for CFSImport.
  * @status Incomplete - this code has to be run, but it should be close.
  */

require_once 'lib/CFSImport.php';
$filename = './mydata.csv';
$cfs = new CFSImport($filename);
$ef = array('Start Time', 'End Time', 'Employee', 'Location', 'SKU', 'Quantity');
$cfs->set_expectedfields($ef);

// The following fragment will create a composite virtual field based on the
// two real fields, SKU and Location.
$cfs->init_transformation('department');
$cfs->add_transformation_l('department', 'SKU', 2);
$cfs->add_transformation_l('department', 'Location', 5);
$cfs->add_transformation_t('department', '-');
$cfs->close_transformation('department');

$cfs->process_file();
?>
