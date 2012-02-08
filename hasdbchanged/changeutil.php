<?php
require_once('IDBAttributes.inc');
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
class TableUtility
{
	private $m_host = null;
	private $m_user = null;
	private $m_pass = null;
	private $m_port = null;
	private $m_database = null;
	private $m_table = null;

	private $m_mysqli = null;


	// output seperators etc
	private $colsep = ':';
	public function __construct()
	{
	}
/*
	public function setInformation($database, $table)
	{
		// TODO: check for null
		$this->m_database = $database;
		$this->m_table = $table;
	}
*/
	public function setInformation(iDBAttributes $dbattrib)
	{
		$this->m_host = $dbattrib->getHost();
		$this->m_user = $dbattrib->getUser();
		$this->m_pass = $dbattrib->getPass();
		$this->m_port = $dbattrib->getPort();
		$this->m_database = $dbattrib->getDatabase();
		$this->m_table = $dbattrib->getTable();
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
	public function getBasicColumnDataType()
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
			$retBasicCDT = $this->p_getBasicColumnDataType();
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
	private function p_init()
	{
		$this->m_mysqli = new mysqli($this->m_host, $this->m_user, $this->m_pass, $this->m_database);
		if ($this->m_mysqli->connect_errno)
		{
			$errMsg = "Failed to connect to MySQL: (" . $m_mysqli->connect_errno . ") " . $this->m_mysqli->connect_error;
			echo "$errMsg";
			throw new Exception($errMsg);
		}
		echo $this->m_mysqli->host_info . "\n";
	}
	private function p_uninit()
	{
		if ($this->m_mysqli != null)
		{
			$this->m_mysqli->close();
		}
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
	private function p_getBasicColumnDataType()
	{
		$retValue = "";
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
			$retValue .= $columnName;
			$retValue .= COLDATATYPE_SEP;
			$retValue .= $columnType;
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
}
?>
