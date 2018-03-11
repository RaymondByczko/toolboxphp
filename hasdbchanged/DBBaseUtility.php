<?php
namespace hasdbchanged;
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
		$this->m_mysqli = new \mysqli($this->m_host, $this->m_user, $this->m_pass, $this->m_database);
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
?>
