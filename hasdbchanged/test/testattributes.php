<?php

	require_once('../IDBAttributes.inc');
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
			return '3306';
		}
		public function getDatabase()
		{
			return '';
		}
		public function getTable()
		{
			return '';
		}
	}
?>
