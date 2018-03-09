<?php
/*
 * @file IDBSnapshot.php
 * @location ./hasdbchanged/
 * @company self
 * @author Raymond Byczko
 * @start_date
 * @purpose To provide an interface for a database snapshot.
 * @change_history RByczko;2018-03-08;
 * Namespaces are now used along with 'use'.
 * This is done to make it more PHPUnit and TravisCI friendly.
 */
?>
<?php
	namespace hasdbchanged;

	interface IDBSnapshot
	{
		public function getNumberColDataTypePairs();
		public function getColDataPair($index);
	}
?>
