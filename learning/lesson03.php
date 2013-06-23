<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file lesson03.php
  * @start_date 2013-06-23 June 23.
  * @purpose To learn more about php.  Specifically, how visibility
  * affects access to public and private members.  In one case,
  * a public method can recieve an object of the same type and
  * access its private components.  See MyCoordinate.
  * In a second case, a member variable is decorated with only 'var'.
  * Its visibility is then used in client code.  See 'MyFishingSpot'.
  * Lastly, if a member is not defined, then a run-time error is
  * reported in trying to access that which does not exist.  This
  * can be dealt with by the magic function __get.
  * See the following for useful info on __get:
  * 	http://www.tuxradar.com/practicalphp/6/14/2
  * See MyArtSupply for working with __get.
  * @status Nothing outstanding.  All results are as expected.
  */

class MyCoordinate
{
	private $m_x;	
	private $m_y;
	public function __construct($x, $y)
	{
		$this->m_x = $x;
		$this->m_y = $y;
	}
	public function output()
	{
		echo 'output: start'."\n";
		echo 'm_x='.$this->m_x."\n";
		echo 'm_y='.$this->m_y."\n";
	}
	// output_other: the point of this demo class
	// is in this method - it allows passing
	// an object of this type and seeing its private
	// members.
	public function output_other($other)
	{
		echo 'output_other: start'."\n";
		echo 'm_x='.$other->m_x."\n";
		echo 'm_y='.$other->m_y."\n";
	}
}

echo '===== section 1 ====='."\n";
$objCoord01 = new MyCoordinate(4,5);
$objCoord01->output();
echo '===== section 2 ====='."\n";
$objCoord02 = new MyCoordinate(7,8);
$objCoord01->output_other($objCoord02);
echo '===== section 3 ====='."\n";
// MyFishingSpot: this class demonstrates what happens
// if a member property is undecorated or if only var is
// used.  In the former, we get a syntax error. In the
// later, the visibility appears to be public.
class MyFishingSpot
{
	// NOTE: removal of var leads to syntax error!
	var $m_lakeName='blank';
	private $m_location='nowhere';
	public function __construct($lakeName, $location)
	{
		$this->m_lakeName = $lakeName;
		$this->m_location = $location;
	}
	public function output_fishingspot()
	{
		echo 'output_fishingspot: start'."\n";	
		echo 'm_lakeName='.$this->m_lakeName."\n";
		echo 'm_location='.$this->m_location."\n";
	}
}
$objFishingSpot3 = new MyFishingSpot('Lake Zoar', 'Shelton');
$objFishingSpot3->output_fishingspot();
$objFishingSpot3->m_lakeName = 'Shelton Lake';
$objFishingSpot3->output_fishingspot();
echo '===== section 4 ====='."\n";
// The purpose of this section is to experiment with the magic
// function __get.  It is described unsufficiently in the
// www.php.net document, so lets try it out.  It does not seem
// to be provided automatically; it has to be specified by the
// developer.
$objFishingSpot4 = new MyFishingSpot('Tyler Lake', 'Goshen');
$objFishingSpot4->output_fishingspot();
// The following does not generate a 'lint' error (with -l), but
// it does generate a run-time error.
// $location4 = $objFishingSpot4->m_location;
// echo 'location4='.$location4;


// The following does generate a 'lint' error, saying __get is undefined.
// $location4b = $objFishingSpot4->__get('m_location');
// echo 'location4b='.$location4b;
echo '===== section 5 ====='."\n";
// I googled '__get php' and found that __get is called when trying
// to read properties not defined in the host class.  So lets see
// what happens when paperweight is read from although its not defined,
// and yet __get is provided.  It turns out a runtime error is not
// encountered.
class MyArtSupply
{
	public $m_type='oil';
	public $m_color='red';
	public function output()
	{
		echo 'MyArtSupply: start'."\n";
		echo 'm_type='.$this->m_type."\n";
		echo 'm_color='.$this->m_color."\n";
	}
	public function __get($unknown_property)
	{
		$rv = 'noted:'.$unknown_property;
		return $rv;
	}
}

$objAS5 = new MyArtSupply();
$objAS5->output();
$objAS5->m_type = 'water color';
$objAS5->m_color = 'green';
$objAS5->output();
// Without a __get, undefined property MyArtSupply::$paperweight is
// reported at run-time.
$pw = $objAS5->paperweight;
echo 'pw='.$pw."\n";


?>
