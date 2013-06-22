<?php
/**
  * @company self
  * @author Raymond Byczko
  * @file lesson01.php
  * @start_date 2013-06-22 June 22
  * @purpose To learn more about php.  Specifically, how is_callable
  * can be applied to sole functions and to methods (private and public)
  * in a class.
  * @status Check out protected methods.
  */

echo '===== section 1 ====='."\n";
function mp()
{
	echo 'Monty Python and the Holy Grail'."\n";
}
mp();
$result = is_callable('mp', false, $callname);
var_dump($result);
var_dump($callname);
echo '===== section 2 ====='."\n";
$result2 = is_callable('mp_notdefined', false, $callname2);
var_dump($result2);
var_dump($callname2);
echo '===== section 3 ====='."\n";
$result3 = is_callable('mp_notdefined2', true, $callname3);
var_dump($result3);
var_dump($callname3);
echo '===== section 4 ====='."\n";
class MyClass
{
	private function myPrivateF()
	{
		echo 'myPrivateF: start'."\n";
	}
	public function myPublicF()
	{
		echo 'myPublicF: start'."\n";
	}
	public function accessToPrivate()
	{
		echo 'accessToPrivate: start'."\n";
		$this->myPrivateF();
	}
}
$objMyClass = new MyClass();
$objMyClass->myPublicF();
echo '===== section 5 ====='."\n";
$objMyClass->accessToPrivate();
echo '===== section 6 ====='."\n";
// $objMyClass->myPrivateF();
echo '===== section 7 ====='."\n";
$result7 = is_callable(array($objMyClass, 'myPublicF'), false, $callname7);
var_dump($result7);
var_dump($callname7);
echo '===== section 8 ====='."\n";
$result8 = is_callable(array($objMyClass, 'myPublicF'), true, $callname8);
var_dump($result8);
var_dump($callname8);
echo '===== section 9 ====='."\n";
$result9 = is_callable(array($objMyClass, 'myPrivateF'), false, $callname9);
var_dump($result9);
var_dump($callname9);
echo '===== section 10 ====='."\n";
$result10 = is_callable(array($objMyClass, 'myPrivateF'), true, $callname10);
var_dump($result10);
var_dump($callname10);
echo '===== section 11 ====='."\n";
$result11 = is_callable(array($objMyClass, 'accessToPrivate'), false, $callname11);
var_dump($result11);
var_dump($callname11);
echo '===== section 12 ====='."\n";
$result12 = is_callable(array($objMyClass, 'accessToPrivate'), true, $callname12);
var_dump($result12);
var_dump($callname12);
?>
