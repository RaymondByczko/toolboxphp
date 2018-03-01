<?php
namespace Testing\hasdbchanged;

use PHPUnit\Framework\TestCase;
// require_once __DIR__.'/../../bootstrap/autoload.php';

class TableUtility01Test extends TestCase
{
	public function testBasicFormat()
	{
		$objTU = new \hasdbchanged\TableUtility();
		$dbattrib = new \hasdbchanged\test\TestAttributes();
		$objTU->setInformation($dbattrib);
		$bf = $objTU->getBasicFormat();
		echo 'basic format='.$bf."\n";
		$this->assertSame($bf,'name:occupation');
	}
}
?>
