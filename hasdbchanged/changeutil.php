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
/*
 * @change_history RByczko, 2018-03-01, Moved DBBaseUtility class to seperate file.
 * @change_history RByczko, 2018-03-01, Moved TableUtility class to seperate file.
 */
// $rootDir = '/home/quickstart/mygithub/toolboxphp/hasdbchanged/';
$rootDir = getenv('HDC_DOCROOT');
require_once($rootDir.'IDBAttributes.inc');
require_once($rootDir.'dbsnapshot.php');
define('COL_SEP', ':');
define('COLDATATYPE_SEP', '#');
define('TBL_SEP', ':');




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
