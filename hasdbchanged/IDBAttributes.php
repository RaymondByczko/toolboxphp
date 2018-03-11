<?php
	namespace hasdbchanged;

	interface IDBAttributes
	{
		public function getHost();
		public function getUser();
		public function getPass();
		public function getPort();
		public function getDatabase();
		public function getTable();
	}
?>
