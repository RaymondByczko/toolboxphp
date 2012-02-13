<?php
	$rootDir='/home/raymond/RByczko002_phpStuff/toolboxphp/hasdbchanged/';
	require_once($rootDir.'IDBAttributes.inc');
	class TestAttributes implements iDBAttributes
	{
		public function getHost()
		{
			return 'localhost';
		}
		public function getUser()
		{
			return '';
		}
		public function getPass()
		{
			return '';
		}
		public function getPort()
		{
			return '';
		}
		public function getDatabase()
		{
			return 'ctlwebservice';
		}
		public function getTable()
		{
			return 'ctloperations';
		}
	}
?>
