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
*/
?>
<?php

	/** Include path **/
	// set_include_path(get_include_path() . PATH_SEPARATOR . '/home/ubuntu/toolboxphp/dbimport/extern/set03/extract_pt/Classes/');
	// set_include_path(get_include_path() . PATH_SEPARATOR . '/home/ubuntu/toolboxphp/dbimport/evaluation/set01/extract_pt/ChartDirector/lib');

	/** PHPExcel_IOFactory */
	// include 'PHPExcel/IOFactory.php';
	// App::import('Vendor', 'PHPExcel/IOFactory', false, array('/home/ubuntu/toolboxphp/dbimport/extern/set03/extract_pt/Classes/'),'IOFactory.php');


	echo 'pifile='.$pifile;
	echo 'base_pifile='.$base_pifile;
	echo $this->Html->image('../../stored_images/'.$base_pifile);

	echo $this->Html->link('Logout here', array('controller'=>'users', 'action'=>'logout'));
	return;
	$debug = 0;
	$retA1 = App::import('Vendor', 'PHPExcel_IOFactory', array('file'=>'PHPExcel'.DS.'IOFactory.php'));
	if ($debug) { echo 'retA1='.$retA1;}
	$retA2 = App::import('Vendor', 'PieChart', array('file'=>'ChartDirector'.DS.'lib'.DS.'phpchartdir.php'));
	if ($debug) { echo 'retA2='.$retA2;}
	if ($debug) { echo 'rdata=';};
	if ($debug) { pr($rdata);}
	if ($debug) { echo 'upload='.$upload; }
	if ($debug) { echo 'stored='.$stored; }

	if ($debug)
	{
		echo 'Loading file ',pathinfo($storedfilename,PATHINFO_BASENAME),' (aka sample.xls) using IOFactory to identify the format<br />';
	}
	$objPHPExcel = PHPExcel_IOFactory::load($storedfilename);


	if ($debug) { echo '<hr />'; }

	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	if ($debug) { var_dump($sheetData); }
	$item = $sheetData[1]['A'];
	$count = $sheetData[1]['B'];
	if ($debug) { echo 'item='.$item.'; count='.$count; }
	$labels = array();
	$data = array();
	foreach ($sheetData as $key=>$value)
	{
		$labels[] = $value['A'];
		$data[] = $value['B'];
	}
	
	if ($debug)
	{
		echo 'labels'."\n";
		var_dump($labels);
		echo 'data'."\n";
		var_dump($data);
	}
	// return 0;


	# The data for the pie chart
	// $data = array(35, 30, 25, 7, 6, 5, 4, 3, 2, 1);

	# The labels for the pie chart
	// $labels = array("Labor", "Production", "Facilities", "Taxes", "Misc", "Legal",
	//     "Insurance", "Licenses", "Transport", "Interest");

	# Create a PieChart object of size 560 x 270 pixels, with a golden background and a 1
	# pixel 3D border
	$c = new PieChart(560, 270, goldColor(), -1, 1);

	# Add a title box using 15 pts Times Bold Italic font and metallic pink background
	# color
	$textBoxObj = $c->addTitle("Project Cost Breakdown", "timesbi.ttf", 15);
	$textBoxObj->setBackground(metalColor(0xff9999));

	# Set the center of the pie at (280, 135) and the radius to 110 pixels
	$c->setPieSize(280, 135, 110);

	# Draw the pie in 3D with 20 pixels 3D depth
	$c->set3D(20);

	# Use the side label layout method
	$c->setLabelLayout(SideLayout);

	# Set the label box background color the same as the sector color, with glass effect,
	# and with 5 pixels rounded corners
	$t = $c->setLabelStyle();
	$t->setBackground(SameAsMainColor, Transparent, glassEffect());
	$t->setRoundedCorners(5);

	# Set the border color of the sector the same color as the fill color. Set the line
	# color of the join line to black (0x0)
	$c->setLineColor(SameAsMainColor, 0x000000);

	# Set the start angle to 135 degrees may improve layout when there are many small
	# sectors at the end of the data array (that is, data sorted in descending order). It
	# is because this makes the small sectors position near the horizontal axis, where
	# the text label has the least tendency to overlap. For data sorted in ascending
	# order, a start angle of 45 degrees can be used instead.
	$c->setStartAngle(135);

	# Set the pie data and the pie labels
	$c->setData($data, $labels);

	# Output the chart
	header("Content-type: image/png");
	print($c->makeChart2(PNG));
?>
