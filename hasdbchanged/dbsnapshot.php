<?php
$rootDir = '/home/raymond/RByczko002_phpStuff/toolboxphp/hasdbchanged/';
require_once($rootDir.'idbchange.php');
	class DBSnapshot implements IDBSnapshot
	{
		private $m_colnametypes = null;

		public function __construct(array $columnNameTypes)
		{
			$this->m_colnametypes = array();	
			foreach ($columnNameTypes as $columnname)
			{
				$this->m_colnametypes[] = $columname;
			}
		}
		public function getNumberColDataTypePairs()
		{
			return count($this->m_colnametypes);
		}
		public function getColDataPair($index)
		{
			if (($index >= 0) && ($index <= (count($this->m_colnamestypes))))
			{
				return $this->m_colnametypes[$index];
			}
			return null; // TODO - raise exception - $index out of range.
		}
	}
?>
