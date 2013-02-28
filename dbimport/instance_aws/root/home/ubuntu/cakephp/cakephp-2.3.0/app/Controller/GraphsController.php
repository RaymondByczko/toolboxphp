<?php
// @company self
// @author Raymond Byczko
// @file GraphsController.ph
// @purpose This is the graphs controller which allows uploading/processing
// of xls spreadsheet files.
// @change_log 2013-02-28 Feb 28, RByczko, Added produceimagefile, which works.
// Will add this to git and further refine.  Status is accurate.
// @status incomplete, working, rough, needs refinement
?>
<?php
	class GraphsController extends AppController {
		public $helpers = array('Html', 'Form');

		public function beforeFilter() {
			parent::beforeFilter();
		}
		public function upload()
		{
		}
		public function processxlsimage()
		{
			if (!$this->request->is('post'))
			{

				header("Content-type: text/html");
				echo '<pre>Non post';
				return;
			}
			$this->set('rdata', $this->request->data);
			$tmpfile = $this->request->data['Graph']['xlstoprocess']['tmp_name'];
			if (!is_uploaded_file($tmpfile))
			{
				$this->set('upload', 'Error in uploading');
				return;
			}
			else
			{
				$this->set('upload', 'Success in uploading');
			}
			$actualfile = $this->request->data['Graph']['xlstoprocess']['name'];
			$typeoffile = $this->request->data['Graph']['xlstoprocess']['type'];

			
			$storedfilename = "./stored_xls/".$actualfile;

			/* Add suffix of timestamp.  Return new file name to user */
			if (!move_uploaded_file($tmpfile, $storedfilename))
			{
				$this->set('stored', 'unable to move file - check permissions');
				return;
			}
			else
			{
				$this->set('stored', 'Success in storage');
			}
			$this->set('storedfilename', $storedfilename);
			// $this->response->body = '<pre>No view here';
			// return $this->response;
			$this->response->type('png');
			if (1==1)
			{ ///

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
			$chartdata = $c->makeChart2(PNG);
			// print($c->makeChart2(PNG));
			$this->produceimagefile($chartdata);
			print($chartdata);
			} ///
			return;
		}
		private function produceimagefile(&$imagedata)
		{
			$imagefile = tempnam('./stored_images/', 'graphs_');
			// throw new Exception('Problem2 creating temp file');
			syslog(LOG_DEBUG,'imagefile='.$imagefile);
			if (!$imagefile)
			{
				// Error
				throw new Exception('Problem creating temp file');
			}
			$fh = fopen($imagefile, 'w');
			if (!$fh)
			{
				throw new Exception('Problem with opening file');
			}
			$fw = fwrite($fh, $imagedata);
			if (!$fw)
			{
				fclose($fh);
				throw new Exception('Problem with writing file');
			}
			fclose($fh);
		}
	
	}
?>
