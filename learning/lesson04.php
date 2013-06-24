<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file lesson04.php
  * @start_date 2013-06-24 June 24.
  * @purpose To learn more about php.  Specifically, how __set
  * can be utilized to control how properties are added to an
  * object without their being originally declared in the class
  * of that object.
  * @status Nothing outstanding.  All results are as expected.
  * @important_point 1) Assigning to an undeclared property in
  * an object is not an error at run time or lint time. If 'a'
  * is not found in the definition of class Wood, you can treat
  * 'a' as a property by assigning to it.  Then you can read back from
  * it.  This could lead to problems.  A property may be mis-spelled
  * when accessed through an object - assignment to a mis-spelled
  * property stores the update in the wrong area.  Reading it back
  * correctly, from where its supposed to be, can yield problems
  * since the update never occurred propertly.
  * @important_point 2) One way of producing such an error is to a)
  * define the magic method __set in the class and b) throw an 
  * exception in that class method. This will not lead to a 'lint' error,
  * but will at least produce a runtime error.  See the Metal class for
  * this. 
  * @important_point 3) Using a stub __set method in a class
  * is a way to avoid introducing new properties to an object at
  * run-time and to insure they are declared in the class definition.
  */
class Wood
{
	public $length;
	public $width;
	public $other;
	public function __construct($length, $width)
	{
		$this->length = $length;
		$this->width = $width;
		$this->other = 'notset';
	}
	public function output()
	{
		echo 'Wood::output-start'."\n";
		echo 'length='.$this->length."\n";
		echo 'width='.$this->width."\n";
	}

}

echo '===== section 1 ====='."\n";
$objWood01 = new Wood(4,5);
$objWood01->output();
echo '===== section 2 ====='."\n";
$objWood02 = new Wood(4,5);
$objWood02->output();
$objWood02->a = 'oak';
echo 'a is '.$objWood02->a;
echo '===== section 3 ====='."\n";
class Metal
{
	public $metalname;
	public $finish;
	public function __construct($metalname, $finish)
	{
		$this->metalname = $metalname;
		$this->finish = $finish;
	}
	public function output()
	{
		echo 'Metal::output-start'."\n";
		echo 'metalname='.$this->metalname."\n";
		echo 'finish='.$this->finish."\n";
	}
	public function __set($setname, $setvalue)
	{
		throw new Exception('Cant assign to values that dont exist');
	}
}

$objMetal3 = new Metal('copper', 'enameled');
$objMetal3->output();
try {
	$objMetal3->weight = 1.4;
}
catch (Exception $e)
{
	echo 'Caught exception here'."\n";
	echo 'message='.$e->getMessage()."\n";
}
echo '===== section 4 ====='."\n";
class Plastic
{
	public $grade;
	public function __construct($grade)
	{
		$this->grade = $grade;
	}
	public function output()
	{
		echo 'Plastic::output-start'."\n";
		echo 'grade='.$this->grade;
	}
	public function __set($setname, $setvalue)
	{
		// This stub implementation should not yield an
		// error but will not add the undefined property to
		// the object.  An error is encountered when
		// an attempt is made to readback color and its
		// not there and we don't have a __get method.
	}
}

$objPlastic4 = new Plastic('highgrade');
$objPlastic4->output();
// The following does not produce an error and color is not introduced
// to $objPlastic4.
$objPlastic4->color = 'red';
// The following does produce an error because color was never added to the
// object.
echo 'color='.$objPlastic4->color."\n";
echo '===== section 5 ====='."\n";

?>
