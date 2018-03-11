<?php
/*
 * @file TableUtility02Test.php
 * @location ./testing/hasdbchanged/
 * @company self
 * @author Raymond Byczko
 *
 * @purpose To process a database snapshot with regard to what column
 * names and titles are present.
 * @change_history RByczko;2018-03-08; Added this file header.
 * Added table to string that will be tested in assert.
 * @todo This file depends on table setup via a sql script.
 * Thus the varchar(20), varchar(10).  This is probably not optimum
 * since that file is not directly referenced in this file.
 * Maybe a call to file_exists to indicate the connection better??
 */
?>
<?php
use PHPUnit\Framework\TestCase;

class TableUtility02Test extends TestCase
{
	public function testBasicColumnDataType()
	{
		$objTU = new \hasdbchanged\TableUtility();
		$dbattrib = new \hasdbchanged\test\TestAttributes();
		$objTU->setInformation($dbattrib);
		$bcdt = $objTU->getBasicColumnDataType();
		// echo 'basic column data type='.$bcdt."\n";
		$tbl = $dbattrib->getTable();
		$this->assertSame($bcdt,$tbl.'*name#varchar(20):occupation#varchar(10)');
	}
}
?>
