<?php
/*
 * @file TableUtility04Test.php
 * @location ./testing/hasdbchanged/
 * @company self
 * @author Raymond Byczko
 *
 * @purpose To test getFullFormat.
 * @change_history RByczko;2018-03-08; Added this file header.
 * @note This provides an example of full analysis of an array,
 * via is_array, array_key_exists, count etc.  This might
 * be useful to automate or break down into a generated function/
 * method. Perhaps give the method an example, and generate
 * the correct sequence of is_array, array_key_exists etc.
 * Then store that sequence, and apply to other arrays.
 */
?>
<?php
use PHPUnit\Framework\TestCase;

class TableUtility04Test extends TestCase
{

	/**
	  *
	  */
	public function testFullFormat()
	{
		$objTU = new \hasdbchanged\TableUtility();
		$dbattrib = new \hasdbchanged\test\TestAttributes();
		$objTU->setInformation($dbattrib);
		$fullFormat = $objTU->getFullFormat();
		echo 'fullFormat='.var_export($fullFormat, TRUE)."\n";

		$this->assertSame(is_array($fullFormat), TRUE);
		$this->assertSame(array_key_exists('name', $fullFormat), TRUE);
		$this->assertSame($fullFormat['name'], 'toolboxphp_test');
		$this->assertSame(array_key_exists('tables', $fullFormat), TRUE);
		$this->assertSame(is_array($fullFormat['tables']), TRUE);
		$this->assertSame(count($fullFormat['tables']), 1);

		$this->assertSame(is_array($fullFormat['tables'][0]), TRUE);

		$this->assertSame(array_key_exists('name', $fullFormat['tables'][0]), TRUE);
		$this->assertSame(array_key_exists('cols', $fullFormat['tables'][0]), TRUE);

		$this->assertSame(is_array($fullFormat['tables'][0]['cols']), TRUE);

		$this->assertSame(count($fullFormat['tables'][0]['cols']), 2);

		$this->assertSame(is_array($fullFormat['tables'][0]['cols'][0]), TRUE);
		$this->assertSame(is_array($fullFormat['tables'][0]['cols'][1]), TRUE);

		$this->assertSame(array_key_exists('type', $fullFormat['tables'][0]['cols'][0]), TRUE);
		$this->assertSame(array_key_exists('name', $fullFormat['tables'][0]['cols'][0]), TRUE);

		$this->assertSame(array_key_exists('type', $fullFormat['tables'][0]['cols'][1]), TRUE);
		$this->assertSame(array_key_exists('name', $fullFormat['tables'][0]['cols'][1]), TRUE);

		$this->assertSame($fullFormat['tables'][0]['cols'][0]['name'], 'name');
		$this->assertSame($fullFormat['tables'][0]['cols'][0]['type'],'varchar(20)');


		$this->assertSame($fullFormat['tables'][0]['cols'][1]['name'], 'occupation');
		$this->assertSame($fullFormat['tables'][0]['cols'][1]['type'], 'varchar(10)');


	}
}
?>
