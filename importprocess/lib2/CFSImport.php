<?php
class CFSImport
{
	/**
	  * m_transformations: each element represents a virtual column
	  * comprised of 1 or more pieces from 1 or more real columns in the
	  * CSV file.
	  */
	private $m_transformations = array();
	/**
	  * m_expectedfields: this represents what is expected as the header
	  * at the top of the imported CSV file.
	  */
	private $m_expectedfields = null;
	/**
	  * m_EmployeeL: each array element represents the location data for one
	  * employee.  Accordingly, the index is the Employee number.  Each
	  * array element represents a distinct array.  This distinct array is
	  * built as the StartTime associated array is.
	  */
	private $m_EmployeeL = array();
	/**
	  * m_EmployeeS: each array element represents the Start Times for one
	  * employee.  Accordingly, the index is the Employee number.  Each
	  * array element represents a distinct array.  This distinct array is
	  * built as the Location associated array is.
	  */
	private $m_EmployeeS = array();
	public function __construct($filename)
	{
		$this->m_filename = $filename;
	}
	public function set_expectedfields($ef)
	{
		$this->expectedfields = $ef;
	}
	public function init_transformation($key)
	{
		$texists = array_key_exists($key, $this->transformations);
		if (!texists)
		{
			$this->transformations[$key] = array();
		}
	}
	public function add_transformation_c($key, $column, $start, $end)
	{
		$texists = array_key_exists($key, $this->transformations);
		if (texists)
		{
			$this->transformations[$key][] = array('type'=>'c','column'=>$column, 'start'=>$start, 'end'=>$end);
		}
		else
		{
			throw Exception('initialize tranformation with init_transformation');
		}
	}
	public function add_transformation_t($key, $token)
	{
		$texists = array_key_exists($key, $this->transformations);
		if (texists)
		{
			$this->transformations[$key][] = array('type'=>'t','token'=>$token);
		}
		else
		{
			throw Exception('initialize tranformation with init_transformation');
		}
	}
	public function process_file()
	{
		$row = 1;
		// Open csv file.
		if (($handle = fopen($this->m_filename, "r")) !== FALSE)
		{
			// Acquire the header.
			if ($data = fgetcsv($handle, 1, ",")) !== FALSE)
			{
				
				$num_afields = count($data);
				$num_efields = count($this->m_expectedfields); 
				if ($num_afields != $num_efields)
				{
					throw Exception('num_afields='.$num_afields.';num_efields='.$num_efields);
				}
			}
			// Process each line
			while (($data = fgetcsv($handle, 1, ",")) !== FALSE) {
				$StartTime = $data[0];
				$EndTime = $data[1];
				$Employee = $data[2];
				$Location = $data[3];
				$SKU = $data[4];
				$Quantity = $data[5];
				// Store Location per Employee.
				if (array_key_exists($Employee,$this->m_EmployeeL))
				{
					$this->m_EmployeeL[$Employee][] = $Location;
				}
				// Store StartTime per Employee.
				if (array_key_exists($Employee,$this->m_EmployeeS))
				{
					$this->m_EmployeeS[$Employee][] = $StartTime;
				}
				// Note: Above Store operations insure aligned order
				// which will be utilized under multisort.
				$row++;
			}
			fclose($handle);
			// Sort the StartTime component and have Location follow.
			foreach ($this->mEmployeeS as $curEmployee=>$curEmployeeStart)
			{
				array_multisort($this->m_EmployeeS($curEmployee), $this->m_EmployeeL($curEmployee));
			}
		}
		
	}
}
?>
