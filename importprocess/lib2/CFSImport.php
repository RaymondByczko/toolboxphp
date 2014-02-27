<?php
/**
  * @file lib2/CFSImport.php
  * @company self
  * @author Raymond Byczko
  * @purpose To provide a FileSystem based import mechanism.
  * One line is read at a time (I know..inefficient) and various
  * metrics are calculated during one pass.
  *
  * Besides a solution with fgetcsv, this solution prototypes something
  * called a transformation, whereby a new composite virtual column
  * is made from 1 or more real columns in the csv data.
  * Further, tokens, like a dash can be inserted at any point to create
  * the new virtual column.
  * @start_date 2014-02-26 Feb 26
  * @status Incomplete - not all desired metrics (quantity) are calculated.
  * Further, a few additional methods have to be added to provide service
  * to the client code.  Lastly, a buffer_fgetcsv needs to be written,
  * and abstracted to a base class, so we don't read 1 line at a time,
  * while still conserving memory.
  */


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

	/**
	  * m_errorList: is an array of arrays.  Each subarray has keys: line, errorFound, ignored.
	  */
	private $m_errorList = array();
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
			$this->transformations[$key][0] = array('status'=>'open');
		}
	}
	public function add_transformation_c($key, $column, $start, $end)
	{
		$texists = array_key_exists($key, $this->transformations);
		if (texists)
		{
			// @TODO test to determine if status is open.
			$this->transformations[$key][] = array('type'=>'c','column'=>$column, 'start'=>$start, 'end'=>$end);
		}
		else
		{
			throw Exception('initialize tranformation with init_transformation');
		}
	}
	public function add_transformation_l($key, $column, $left)
	{
		$texists = array_key_exists($key, $this->transformations);
		if (texists)
		{
			// @TODO test to determine if status is open.
			$this->transformations[$key][] = array('type'=>'l','column'=>$column, 'left'=>$left);
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
			// @TODO test to determine if status is open.
			$this->transformations[$key][] = array('type'=>'t','token'=>$token);
		}
		else
		{
			throw Exception('initialize tranformation with init_transformation');
		}
	}
	public function close_transformation($key)
	{
		$texists = array_key_exists($key, $this->transformations);
		if (texists)
		{
			$this->transformations[$key][0] = array('status'=>'closed');
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
			while (($data = fgetcsv($handle)) !== FALSE) {
				$row++;
				if (count($data) != count($this->m_expectedfields))
				{
					$this->m_errorList[] = array('line'=>$row, 'errorFound'=>'number of fields not correct', 'ignored'=>true);				
					continue;
				}
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
