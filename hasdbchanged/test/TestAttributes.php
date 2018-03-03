<?php
	namespace hasdbchanged\test;

	// require_once('../IDBAttributes.inc');
	class TestAttributes implements \hasdbchanged\IDBAttributes
	{
		public function getHost()
		{
			return '127.0.0.1';
		}
		public function getUser()
		{
			return 'travis';
		}
		public function getPass()
		{
			return '';
		}
		public function getPort()
		{
			return '3306';
		}
		public function getDatabase()
		{
			return 'toolboxphp_test';
		}
		public function getTable()
		{
			return 'users';
		}
	}
?>
