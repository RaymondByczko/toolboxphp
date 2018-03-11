<?php
/*
 * @file TableUtility.php
 * @location ./hasdbchanged/
 * @company self
 * @author Raymond Byczko
 *
 * @purpose To provide the capability of reading the schema of database tables
 * and producing serialized strings of their structure.  These can then be
 * saved and compared etc.
 * @change_history RByczko;2018-03-08; Added TABLE_POST_SEP.  Add this file header.
 * Added FullFormat.
 * @todo There are a number of defines which can be allocated to a method etc.
 * @todo There are a number of echos which can be either removed or
 * otherwise dealt with.
 */
?>
<?php
namespace hasdbchanged;
use hasdbchanged\DBSnapshot;

define('COL_SEP', ':');
define('COLDATATYPE_SEP', '#');
define('TABLE_POST_SEP', '*');

/*
 * TableUtility: given a database and table name, this class produces
 * a serialized version of a description of that table.  Such
 * a serialized version can be saved, and compared with other versions
 * produced at other times.
 *
 * The format available can vary.
 *
 * Basic format provides simply column names in alphabetical order. The
 * column names are seperated by ':'.
 * Basic Column Data type provides column name with its datatype.
 * Each column name and corresponding datatype is seperated by '#'.
 * Column name#datatype pairs are seperated by other ones with a ':'.
 *
 * FullFormat: database name, each table, its name, column names and types.
 * Returned in php array format.
 */
class TableUtility extends \hasdbchanged\DBBaseUtility
{


	// output seperators etc
	private $colsep = ':';
	public function __construct()
	{
	}
	// getBasicFormat: returns serialized format of table structure
	// in basic format.
	public function getBasicFormat()
	{
		$retBasicFormat = "";
		try {
			$this->p_init();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			throw $e;
		}
		try {
			$retBasicFormat = $this->p_getBasicFormat();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			throw $e;
		}
		try {
			$this->p_uninit();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			throw $e;
		}
		return $retBasicFormat;
	}
	public function getBasicColumnDataType($format = "COLON_SEPARATED")
	{
		$retBasicCDT = "";
		try {
			$this->p_init();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			throw $e;
		}
		try {
			$retBasicCDT = $this->p_getBasicColumnDataType($format);
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			throw $e;
		}
		try {
			$this->p_uninit();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			throw $e;
		}
		return $retBasicCDT;
	}
	public function getBasicColumnDataTypeDBSnapshot()
	{
		$retColDatatype = $this->getBasicColumnDataType("ARRAY");
		echo 'get..DBSnap..='.var_export($retColDatatype, TRUE)."\n";
		$objDBSS = new \hasdbchanged\DBSnapshot($retColDatatype);
		return $objDBSS;
	}

	/*
	 * Gets the basic format which is column names
	 * seperated by colons.  No reference to database
	 * nor table is made.
	 */
	private function p_getBasicFormat()
	{
		$retValue = "";
		$query = "select COLUMN_NAME from ";
		$query .= "INFORMATION_SCHEMA.COLUMNS ";
		$query .= "WHERE TABLE_NAME = ?";

		$stmt = $this->m_mysqli->prepare($query);

		$stmt->bind_param('s', $tblName); 
		$tblName = $this->m_table;
		$stmt->execute();
		$stmt->bind_result($columnName);
		$numCols = 0;
		while($stmt->fetch())
		{
			$numCols++;
			$retValue .= $columnName;
			$retValue .= COL_SEP;

		}
		if ($numCols > 0)
		{
			// Remove the last COL_SEP.
			$lenRetValue = strlen($retValue);
			$temp = substr($retValue, 0, ($lenRetValue-1));
			$retValue = $temp;
		}
		$stmt->close();
		return $retValue;
	}
	// p_getBasicColumnDataType: returns the column names and
	// each of the datatypes associated with each column, for
	// the table specified by m_table in the database specified
	// by m_database.  Different formats are entertained (either
	// COLON_SEPARATED or ARRAY.
	//
	// The format for ARRAY is:
	//1		array("$tablename" => array(
	//2				array('type'=>$type, 'name'=>$name),
	//3				.
	//4				.
	//5				array('type'=>$type, 'name'=>$name),
	//6			)
	//		)
	//
	// Client code must pick off the first key of the returned array.
	// That will be the table name.
	// The value associated with that key will be a secondary array.
	// That secondary array will have int index values.  Each element
	// of the secondary array will have 'type' and 'name' keys.
	//
	private function p_getBasicColumnDataType($format)
	{
		if ( !(	($format == 'COLON_SEPARATED') ||
			($format == 'ARRAY')
		))
		{
			throw new \Exception("Unrecognized format"); // TODO - FIX
		}
		$retValue = NULL;
		if ($format == "COLON_SEPARATED")
		{
			$retValue .= $this->m_table.TABLE_POST_SEP;
		}
		else if ($format == "ARRAY")
		{
			/// $tmp = $this->m_table;
			/// $retValue[$tmp] = array(5,6);
			// $retValue = array($tmp => array(5,6));
			$retValue["$this->m_table"] = array();
			echo 'm_tab1..='.$this->m_table."\n";
			echo 'var exp..='.var_export($retValue, TRUE);
			/// return $retValue;
		}
		$query = "select COLUMN_NAME, COLUMN_TYPE from ";
		$query .= "INFORMATION_SCHEMA.COLUMNS ";
		$query .= "WHERE TABLE_NAME = ?";

		$stmt = $this->m_mysqli->prepare($query);

		$stmt->bind_param('s', $tblName); 
		$tblName = $this->m_table;
		$stmt->execute();
		$stmt->bind_result($columnName, $columnType);
		$numCols = 0;
		while($stmt->fetch())
		{
			$numCols++;
			if ($format == 'COLON_SEPARATED')
			{
				$retValue .= $columnName;
				$retValue .= COLDATATYPE_SEP;
				$retValue .= $columnType;
				$retValue .= COL_SEP;
			}
			if ($format == 'ARRAY')
			{
				$newElement = array("name"=>$columnName,
						"type"=>$columnType);
				$retValue[$this->m_table][] = $newElement;
				echo 'm_tab..'.$this->m_table."\n";
			}

		}
		if ( ($format== "COLON_SEPARATED") && ($numCols > 0) )
		{
			// Remove the last COL_SEP.
			$lenRetValue = strlen($retValue);
			$temp = substr($retValue, 0, ($lenRetValue-1));
			$retValue = $temp;
		}
		$stmt->close();
		return $retValue;
	}

	public function getFullFormat()
	{
		$retFF = NULL;
		try {
			$this->p_init();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			throw $e;
		}
		try {
			$retFF = $this->p_getFullFormat();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			throw $e;
		}
		try {
			$this->p_uninit();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			throw $e;
		}
		return $retFF;
	}

	private function p_getFullFormat()
	{
		$database = array(
			'name'=> $this->m_database,
			'tables'=> array(
				array(
					'name'=>$this->m_table,
					'cols'=>array()
				),
			),
		);


		$query = "select COLUMN_NAME, COLUMN_TYPE from ";
		$query .= "INFORMATION_SCHEMA.COLUMNS ";
		$query .= "WHERE TABLE_NAME = ?";

		$stmt = $this->m_mysqli->prepare($query);

		$stmt->bind_param('s', $tblName); 
		$tblName = $this->m_table;
		$stmt->execute();
		$stmt->bind_result($columnName, $columnType);
		$numCols = 0;

		while($stmt->fetch())
		{
			$numCols++;
			$newColumn = array("name"=>$columnName,
					"type"=>$columnType);
			$database['tables'][0]['cols'][] = $newColumn;
		}
		return $database;

	}
}
?>
