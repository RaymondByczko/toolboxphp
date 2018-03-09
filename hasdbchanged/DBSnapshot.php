<?php
/*
 * @file DBSnapshot.php
 * @location ./hasdbchanged/
 * @company self
 * @author Raymond Byczko
 *
 * @purpose To process a database snapshot with regard to what column
 * names and titles are present.
 * @change_history RByczko;2018-03-08; Removed dependence on require_once
 * and now using autoloading.  Namespaces are now used along with 'use'.
 * This is done to make it more PHPUnit and TravisCI friendly.
 */
?>
<?php
namespace hasdbchanged;
use \hasdbchanged\IDBSnapshot;

	class DBSnapshot implements IDBSnapshot
	{
		private $m_colnametypes = null;
		private $m_tablename = null;

		/*
		 * an array of array('name'=>$valuename, 'type'=>$valuetype).
		 * The 'name' and 'type' are associated with a particular column in a database.
		 * The first array is also associative.  Its key is the tablename.
		 * There is only one valid key for the first array.
		 */
		public function __construct(array $columnNameTypes)
		{
			$this->m_colnametypes = array();	
			$tables = array_keys($columnNameTypes);
			if (count($tables) != 1)
			{
				throw new \Exception('Incorrect number of tables');
			}
			$this->m_tablename = $tables[0];
			foreach ($columnNameTypes[$this->m_tablename] as $columnnametype)
			{
				$key_name = array_key_exists('name',$columnnametype);
				$key_type = array_key_exists('type',$columnnametype);
				if (!($key_name && $key_type))
				{
					throw new \Exception('name and type both required');
				}

				echo 'columnnametype='.var_export($columnnametype, TRUE)."\n";
				$this->m_colnametypes[] = $columnnametype;
			}
		}
		public function getNumberColDataTypePairs()
		{
			return count($this->m_colnametypes);
		}

		public function getColDataPair($index)
		{
			if (($index >= 0) && ($index <= (count($this->m_colnametypes))))
			{
				return $this->m_colnametypes[$index];
			}
			return null; // TODO - raise exception - $index out of range.
		}

		public function getTableName()
		{
			return $this->m_tablename;
		}
	}
?>
