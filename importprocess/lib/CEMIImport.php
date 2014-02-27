<?php
/**
  * @file CEMImport.php
  * @note CEMI stands for 'Class EasyMetric Interview'.
  * @company self
  * @author Raymond Byczko
  * @purpose To implement the interface IImport for allowing EasyMetricInterview data to be imported.
  * @start_date 2014-02-26 Feb 26; RByczko.
  * @change_history Starting defining init method utilizing PDO.
  * @status incomplete
  */

require_once 'IImport.php';

class CEMIImport implements IImport 
{
	public function init()
	{
		try {
			// Set Database credentials.
			$host = getenv('IMPORTPROCESS_HOST');
			$dbname = getenv('IMPORTPROCESS_DB');
			$user = getenv('IMPORTPROCESS_USER');
			$pass = getenv('IMPORTPROCESS_PASS');
			// $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
			/// $dbh = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
			$dbh = new PDO('mysql:host='.$host, $user, $pass);
			// Create Database.
			echo '<p>init run'."\n";
		}
		catch (PDOException $pdoe)
		{
			echo '<p>PDOException'."\n";
			$emsg = $pdoe->getMessage();
			echo '<p>emsg='.$emsg."\n";
		}
	}
	public function load_data($filename)
	{
	}
	public function init_transformation($key)
	{
	}
	public function add_transformation_c($key, $column, $start, $end)
	{
	}
	public function add_transformation_t($key, $token)
	{
	}
	public function close_transformation($key)
	{
	}
	public function apply_transformation()
	{
	}
	public function delete_transformation($key)
	{
	}
}
?>
