<?php
// @company self
// @author Raymond Byczko
// @file GraphsController.ph
// @purpose This is the graphs controller which allows uploading/processing
// of xls spreadsheet files.
// @status incomplete, rough, needs refinement
?>
<?php
	class GraphsController extends AppController {
		public $helpers = array('Html', 'Form');
		public function upload()
		{
		}
		public function processxlsimage()
		{
			$rclass = get_class($this->request);
			$this->set('rclass', $rclass);
			// $dkeys = array_keys($this->request->data);
			$pkeys = array_keys($this->request->params);
			$this->set('prams', $this->request->params);
			$this->set('pkeys', $pkeys);
			$this->set('rdata', $this->request->data);
			// if (!is_uploaded_file($this->request->params['xlstoprocess']['tmp_name']))
			if (!is_uploaded_file($this->request->data['Graph']['xlstoprocess']['tmp_name']))
			{
				$this->set('upload', 'Error in uploading');
			}
			else
			{
				$this->set('upload', 'Success in uploading');
			}
		}
	}
?>
