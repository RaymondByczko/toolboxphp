<?php
namespace hasdbchanged;

define('COL_SEP', ':');
define('COLDATATYPE_SEP', '#');

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
		$objDBSS = new DBSnapshot($retColDatatype);
		return $objDBSS;
	}

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
	// by m_database.  Different formats are entertained.
	private function p_getBasicColumnDataType($format)
	{
		if ( !(	($format == 'COLON_SEPARATED') ||
			($format == 'ARRAY')
		))
		{
			throw new \Exception("Unrecognized format"); // TODO - FIX
		}
		$retValue = "";
		if ($format == "COLON_SEPARATED")
		{
		}
		else if ($format == "ARRAY")
		{
			$retValue = array();
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
				$retValue[] = $newElement;
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
}
?>
