<?php
use PHPUnit\Framework\TestCase;
// require_once '../../auto/autoload.php';

class DBBaseUtility01Test extends TestCase
{
	/**
	  * @doesNotPerformAssertions
	  */
	public function testSetInformation()
	{
		$objDBBU = new \hasdbchanged\DBBaseUtility();
		$dbattrib = new \hasdbchanged\test\TestAttributes();
		$objDBBU->setInformation($dbattrib);
	}
}
?>
