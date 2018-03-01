<?php
use PHPUnit\Framework\TestCase;
// require_once '../../auto/autoload.php';

class TableUtility02Test extends TestCase
{
	public function testBasicColumnDataType()
	{
		$objTU = new \hasdbchanged\TableUtility();
		$dbattrib = new \hasdbchanged\test\TestAttributes();
		$objTU->setInformation($dbattrib);
		$bcdt = $objTU->getBasicColumnDataType();
		// echo 'basic column data type='.$bcdt."\n";
		$this->assertSame($bcdt,'name#varchar(20):occupation#varchar(10)');
	}
}
?>
