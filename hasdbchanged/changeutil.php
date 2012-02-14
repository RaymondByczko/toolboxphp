<?php
/*
 * RByczko: classes that provide support for determining stuff
 * in a mysql schema.
 *
 * Documentation Notes
 * -------------------
 * 1) member variables are prefixed with a m_.  For example, m_user.
 * 2) workhouse methods which are protected or private a prefixed
 *    with p_
 *
 * Note: On the existence of private/protected workhouse methods.
 * These exist to essentially isolate code stretches in try/catch
 * blocks.  Client code expects to call public methods, which might
 * throw exceptions, and hopefully preserve object state (exception
 * safety/neutrality).  As a top down approach is taken, it
 * is natural I think to see, an automatic try/catch block right
 * on the surface of the public method.
 */
// $rootDir = '/home/quickstart/mygithub/toolboxphp/hasdbchanged/';
$rootDir = getenv('HDC_DOCROOT');
require_once($rootDir.'IDBAttributes.inc');
require_once($rootDir.'dbsnapshot.php');
define('COL_SEP', ':');
define('COLDATATYPE_SEP', '#');
define('TBL_SEP', ':');


/*
 * DBBaseUtility: provides base operations for a mysqli based
 * implementation, to investigate the schema etc.  The information
 * contained in this base class object is the schema item to be
 * investigated OR it can contain where the schema snapshots are
 * being stored.
 */
class DBBaseUtility
{
	protected $m_host = null;
	protected $m_user = null;
	protected $m_pass = null;
	protected $m_port = null;
	protected $m_database = null;
	protected $m_table = null;

	protected $m_mysqli = null;


	public function setInformation(iDBAttributes $dbattrib)
	{
		$this->m_host = $dbattrib->getHost();
		$this->m_user = $dbattrib->getUser();
		$this->m_pass = $dbattrib->getPass();
		$this->m_port = $dbattrib->getPort();
		$this->m_database = $dbattrib->getDatabase();
		$this->m_table = $dbattrib->getTable();
	}

	protected function p_init()
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
	protected function p_uninit()
	{
		if ($this->m_mysqli != null)
		{
			$this->m_mysqli->close();
		}
	}
}

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
class TableUtility extends DBBaseUtility
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
	public function getBasicColumnDataType($format = "COLON_SEPERATED")
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
			throw new Exception("Unrecognized format"); // TODO - FIX
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

class SchemaUtility extends DBBaseUtility
{

	// getTables: get the tables present in the database
	// indicated.  The choice of database will temporarily override
	// that specified with setInformation if $database is
	// not null.
	public function getTables($database=null)
	{
		$database_ori = null;
		if ($database != null)
		{
			$database_ori = $this->m_database;
			$this->m_database = $database;
		}
		$retGT = "";
		try {
			$this->p_init();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			$this->database = $database_ori;
			throw $e;
		}
		try {
			$retGT = $this->p_getTables();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			$this->database = $database_ori;
			throw $e;
		}
		try {
			$this->p_uninit();
		}
		catch (Exception $e)
		{
			$emsg = $e->getMessage();
			echo "caught exception=".$emsg;
			$this->database = $database_ori;
			throw $e;
		}
		$this->database = $database_ori;
		return $retGT;
	}

	private function p_getTables($database=null)
	{
		$retValue = "";
		$query = "SELECT DISTINCT TABLE_NAME from ";
		$query .= "INFORMATION_SCHEMA.COLUMNS ";
		$query .= "WHERE TABLE_SCHEMA = ?";

		$retprep = $stmt = $this->m_mysqli->prepare($query);
		if ($retprep == FALSE)
		{
			throw new Exception("mysqli->prepare failure");
		}
		$stmt->bind_param('s',$dbName); 
		// $dbName = $this->m_database;
		$dbName = "mycrm";
		$stmt->execute();
		$stmt->bind_result($tableName);
		$numCols = 0;
		while($stmt->fetch())
		{
			$numCols++;
			$retValue .= $tableName;
			$retValue .= TBL_SEP;

		}
		if ($numCols > 0)
		{
			// Remove the last TBL_SEP.
			$lenRetValue = strlen($retValue);
			$temp = substr($retValue, 0, ($lenRetValue-1));
			$retValue = $temp;
		}
		$stmt->close();
		return $retValue;
	}
}
?>
