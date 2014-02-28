<?php
/**
  * @file test/test02.php
  * @company self
  * @author Raymond Byczko
  * @purpose To provide a test harness for CFSImport.
  * @change_history 2014-02-27 Feb27; Added sub-test for quantity
  * per employee.  Added sub-test for error_list for
  * error detection.
  * @status Incomplete - this code runs. The assignment
  * of $filename needs to be researched.
  */

require_once 'lib2/CFSImport.php';
try {

// This kind of works.
$filename = '../data/small_5.csv';

/// $filename = 'data/small_5.csv';
/// $filename = '/data/small_5.csv';
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
$es = $cfs->get_EmployeeS();
$el = $cfs->get_EmployeeL();
echo '<p>--es--<p>'."\n";
var_dump($es);
echo "\n\n";
echo '<p>--el--<p>'."\n";
var_dump($el);
echo "\n\n";
echo '<p>EMPLOYEE START DATA';
foreach ($es as $key_Employee=>$value_StartTimeArray)
{
	echo '<p>Employee='.$key_Employee;
	// echo '<p>...';
	foreach ($value_StartTimeArray as $key=>$value_StartTime)
	{
		echo '<p>...'.$value_StartTime;
	}
}
$cfs->employee_start_data();
$cfs->employee_location_data();
$cfs->quantity_per_employee();
$cfs->error_list();
echo '<p>test02.php-success'."\n";
} catch (Exception $eobj)
{
	$msg = $eobj->getMessage();
	echo $msg."\n";
	$tr = $eobj->getTrace();
	var_dump($tr);

}
echo '<p>test02.php-success2'."\n";
?>
