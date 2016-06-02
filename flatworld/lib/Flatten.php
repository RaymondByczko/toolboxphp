<?php
class Flatten
{
	public function __construct()
	{
	}
	public function it($multiArray)
	{
		$retArray = array();
		foreach ($multiArray as $key=>$value)
		{
			if (is_array($value))
			{
				// Recurse into array.
				$retIt = $this->it($value);
				$retArray[] = $retIt;
			}
			else
			{
				// Append to retArray
				$retArray[] = $value;	
			}
		}
		return $retArray;
	}
}
?>
