<?php
/*
 * @file TableUtility03Test.php
 * @location ./testing/hasdbchanged/
 * @company self
 * @author Raymond Byczko
 *
 * @purpose To test getBasicColumnDataTypeDBSnapshot.
 * @change_history RByczko;2018-03-08; Added this file header.
 * @todo This file depends on sourcing a sql script and
 * setting up things correctly (e.g. varchar(20) reference).
 * In the future, this connection will not be automatically
 * clear.  Maybe use a file_exists to make this explicit?
 */
?>
<?php
use PHPUnit\Framework\TestCase;

class TableUtility03Test extends TestCase
{

	/**
	  */
	public function testgetBasicColumnDataTypeDBSnapshot()
	{
		$objTU = new \hasdbchanged\TableUtility();
		$dbattrib = new \hasdbchanged\test\TestAttributes();
		$objTU->setInformation($dbattrib);
		$snapshot = $objTU->getBasicColumnDataTypeDBSnapshot();
		echo 'snapshot='.var_export($snapshot, TRUE)."\n";
		// $this->assertSame($bcdt,'name#varchar(20):occupation#varchar(10)');

		$num = $snapshot->getNumberColDataTypePairs();
		$this->assertSame($num, 2);

		for ($i=0;$i<$num; $i++)
		{
			$cd = $snapshot->getColDataPair($i);
			echo 'cd='.var_export($cd, TRUE)."\n";
		}


		$tblName = $snapshot->getTableName();

		$this->assertSame($tblName, 'users');

		$this->assertSame($snapshot->getColDataPair(0)['name'], 'name');
		$this->assertSame($snapshot->getColDataPair(0)['type'], 'varchar(20)');

		$this->assertSame($snapshot->getColDataPair(1)['name'], 'occupation');
		$this->assertSame($snapshot->getColDataPair(1)['type'], 'varchar(10)');
	}
}
?>
