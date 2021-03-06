<?php
// @company self
// @author Raymond Byczko
// @file GraphsController.ph
// @purpose This is the graphs controller which allows uploading/processing
// of xls spreadsheet files.
// @change_log 2013-02-28 Feb 28, RByczko, Added produceimagefile, which works.
// Will add this to git and further refine.  Status is accurate.
// @status incomplete, working, rough, needs refinement
// @change_log 2013-03-02 Mar 2, RByczko, Minor adjustments to produce
// an imagefile, whose details are then handed to the view.
// @change_log 2013-03-02 Mar 2, RByczko, Modifications to account for various
// spreadsheet assumptions like a) first row has data or not b) usage
// of first column (data or label).
// @change_log 2013-03-02 Mar 2, RByczko, Rendered error_processxlsimage
// when an error is encountered in that method.
// @change_log 2013-03-09 Mar 9, RByczko, Save file/image details when
// producing output for processxlsimage.
// @change_log 2013-03-09 Mar 9, RByczko, Added history feature so each
// user can see what they have uploaded.
// @change_log 2013-03-11 Mar 11, RByczko, Added piechart and bargraph
// methods to offer more ways of representing data. The signatures of
// each are as follows:
//	piechart($labels, $data, &$pifile)
//	bargraph($labels, $data, &$pifile)
?>
<?php
	class GraphsController extends AppController {
		public $helpers = array('Html', 'Form');

		public function beforeFilter() {
			parent::beforeFilter();
		}
		public function history($user_id = null)
		{
			$user_id = $this->Auth->user('id');
			syslog(LOG_DEBUG, 'user_id(3)='.$user_id);
			$user_history = $this->Graph->find('all', 
				array(
				'conditions'=>array('Graph.user_id'=>$user_id),
				'fields'=>array('Graph.id','Graph.filename_xls', 'Graph.filename_image')
				)
			);
			$this->set('user_history', $user_history);
		}
		public function upload($user_id = null)
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
				$msg = 'is_uploaded_file failure'."\n";
				$msg .= 'details'."\n";
				$msg .= '...tmpfile='.$tmpfile."\n";
				$this->set('msg', $msg);
				$this->render('error_processxlsimage');
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

				$msg='move_uploaded_file failure'."\n";
				$msg.='details'."\n";
				$msg.='...tmpfile='.$tmpfile."\n";
				$msg.='...storedfilename='.$storedfilename."\n";
				$this->set('upload', 'Error in uploading');
				$this->set('msg', $msg);
				$this->render('error_processxlsimage');
				return;
			}
			else
			{
				$this->set('stored', 'Success in storage');
			}
			$this->set('storedfilename', $storedfilename);
			//// RAB 2013-02-28
			//// $this->response->type('png');
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

			$heading = $this->request->data['Graph']['columnheading'];
			$this->set('heading', $heading);
			syslog(LOG_DEBUG,'heading='.$heading);
			$skipUntil = -1;
			if ($heading == 'notpresent')
				$skipUntil = -1;
			if ($heading == 'row1')
				$skipUntil = 0;
			if ($heading == 'row2')
				$skipUntil = 1;


			$columnusage = $this->request->data['Graph']['columnusage'];
			syslog(LOG_DEBUG,'columnusage='.$columnusage);
			$numRow = 0;
			foreach ($sheetData as $key=>$value)
			{
				$numRow++;
				if ( ($numRow-1) <= $skipUntil)
				{
					continue;
				}
				if ($columnusage == 'alabel_bdata')
				{
					$labels[] = $value['A'];
					$data[] = $value['B'];
				}
				if ($columnusage == 'adata_blabel')
				{
					$data[] = $value['A'];
					$labels[] = $value['B'];
				}
			}
			
			if ($debug)
			{
				echo 'labels'."\n";
				var_dump($labels);
				echo 'data'."\n";
				var_dump($data);
			}

			$graphtype = $this->request->data['Graph']['graphtype'];
			if ($graphtype == 'piechart')
			{
				$this->piechart($labels, $data, &$pifile);
			}
			if ($graphtype == 'bargraph')
			{
				$this->bargraph($labels, $data, &$pifile);
			}

			$this->set('pifile', $pifile);
			$path_parts = pathinfo($pifile);
			$base_pifile = $path_parts['basename'];
			$this->set('base_pifile', $base_pifile);
			$user_id = $this->Auth->user('id');
			syslog(LOG_DEBUG, 'user_id(2)='.$user_id);
			$this->Graph->save(array(
				'user_id'=>$user_id,
				'filename_xls'=>$storedfilename,
				'filename_image'=>$pifile
				)
				);
			} ///
			return;
		}
		private function produceimagefile(&$imagedata /* in */, &$ifile /* out */)
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
			$ifile = $imagefile;
		}

		private function piechart(
					$labels /*in*/,
					$data /*in*/,
					&$pifile /*out*/)
		{

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
			//// RAB 2013-02-28
			// header("Content-type: image/png");
			$chartdata = $c->makeChart2(PNG);
			$pifile = null;
			$this->produceimagefile($chartdata, $pifile);
		}

		private function bargraph(
					$labels /*in*/,
					$data /*in*/,
					&$pifile /*out*/)
		{
			$c = new XYChart(250, 250);
			$c->setPlotArea(30, 20, 200, 200);
			$c->addBarLayer($data);
			$c->xAxis->setLabels($labels);
			$chartdata = $c->makeChart2(PNG);
			$pifile = null;
			$this->produceimagefile($chartdata, $pifile);
		}
	
	}
?>
