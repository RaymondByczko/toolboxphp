<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file lesson08.php
  * @start_date 2013-06-30 June 30.
  * @purpose To learn more about php.  Specifically, objects and how
  * they can be cast to arrays.
  * @status Nothing outstanding.  All results are as expected.
  * @important_point 1) Running 'php -l -f <file>' reveals syntax issues.
  * It is indicated with the shorthand of [1].
  * @important_point 2) Section 1 proves that if all public members,
  * then the properties but not the methods make it into the array.
  * @important_point 3) Section 2 proves that Closures saved to public
  * members are used to initialize an array when an object containing
  * a closure is assigned to an array.
  * @important_point 4) Section 3 shows how when an object containing
  * a private variable is cast to an array, the private variable
  * is availalbe in the array, but its key is the concatenation of the
  * class type and the name of the variable.
  * @important_point 5) Section 4 shows what happens when dealing with
  * an empty class defintion (no members, no function) and how
  * an object of that type can be cast to an array.
  */
echo '===== section 1 ====='."\n";
class A {
	public $x;
	public $y;
	public function __construct($xval, $yval)
	{
		echo '... A::construct'."\n";
		$this->x = $xval;
		$this->y = $yval;
	}
	public function output()
	{
		echo '... A::output'."\n";
		echo 'x= '.$this->x."\n";
		echo 'y= '.$this->y."\n";
	}
}

$aObject = new A(4,5);
var_dump($aObject);
$arrayA = (array)$aObject;
var_dump($arrayA);
echo '===== section 2 ====='."\n";
class B {
	public $x;
	public $y;
	public $f_add;
	public function __construct($xval, $yval)
	{
		echo '... B::construct'."\n";
		$this->x = $xval;
		$this->y = $yval;
		$this->f_add = function ($a1, $a2)
		{
			$sum = $a1 + $a2;
			return $sum;
		};
	
	}
	public function output()
	{
		echo '... B::output'."\n";
		echo 'x= '.$this->x."\n";
		echo 'y= '.$this->y."\n";
		/// The following cannot be done.  Cant cast to string.
		/// echo 'f_add= '.(string)$this->f_add."\n";
	}
}

$bObject = new B(10,11);
var_dump($bObject);
$arrayB = (array)$bObject;
var_dump($arrayB);
$bObject->output();
$myadder = $bObject->f_add;
$sum55 = $myadder(44,11);
echo 'sum55='.$sum55."\n";
echo '===== section 3 ====='."\n";
class C {
	public $i;
	private $j;
	public $k;
	public function __construct($ival, $jval, $kval)
	{
		echo '... C::__construct'."\n";
		$this->i = $ival;
		$this->j = $jval;
		$this->k = $kval;
	}
	public function output()
	{
		echo 'i='.$this->i."\n";
		echo 'j='.$this->j."\n";
		echo 'k='.$this->k."\n";
	}
}
$cObject = new C(7,8,9);
$cObject->output();
var_dump($cObject);
$arrayC = (array)$cObject;
var_dump($arrayC);
echo '===== section 4 ====='."\n";
class D {
}
$dObject = new D();
var_dump($dObject);
$arrayD = (array)$dObject;
var_dump($arrayD);
echo '===== section 5 ====='."\n";
