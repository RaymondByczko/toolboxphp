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
  * @change_history 2014-02-27 Feb 27; RByczko; Added employee_start_data,
  * employee_location_data. Fixed a number of bugs (incorrect names for
  * member variables), fixed throw call, fixed logic for m_EmployeeS and
  * for m_EmployeeL.
  * @change_history 2014-02-27 Feb 27; RByczko; Added method:
  * get_QuantityPerEmployee() with associated private data members. Also
  * added error_list for error reporting.
  * @status Incomplete - not all desired metrics (quantity) are calculated.
  * Further, although additional methods have been added to provide service
  * to the client code, a way of resetting an object can be implemented so
  * that a new file can be imported. Lastly, a buffer_fgetcsv needs to be written,
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

	private $m_QuantityPerEmployee = array();

	/**
	  * m_errorList: is an array of arrays.  Each subarray has keys: line, errorFound, ignored.
	  */
	private $m_errorList = array();
	public function __construct($filename)
	{
		$this->m_filename = $filename;
	}
	public function get_errorList()
	{
		return $this->m_errorList;
	}
	public function set_expectedfields($ef)
	{
		$this->m_expectedfields = $ef;
	}
	public function get_EmployeeS()
	{
		return $this->m_EmployeeS;
	}
	public function get_EmployeeL()
	{
		return $this->m_EmployeeL;
	}
	public function get_QuantityPerEmployee()
	{
		return $this->m_QuantityPerEmployee;
	}
	public function init_transformation($key)
	{
		$texists = array_key_exists($key, $this->m_transformations);
		if (!$texists)
		{
			$this->m_transformations[$key] = array();
			$this->m_transformations[$key][0] = array('status'=>'open');
		}
	}
	public function add_transformation_c($key, $column, $start, $end)
	{
		$texists = array_key_exists($key, $this->m_transformations);
		if ($texists)
		{
			// @TODO test to determine if status is open.
			$this->m_transformations[$key][] = array('type'=>'c','column'=>$column, 'start'=>$start, 'end'=>$end);
		}
		else
		{
			throw new Exception('initialize tranformation with init_transformation');
		}
	}
	public function add_transformation_l($key, $column, $left)
	{
		$texists = array_key_exists($key, $this->m_transformations);
		if ($texists)
		{
			// @TODO test to determine if status is open.
			$this->m_transformations[$key][] = array('type'=>'l','column'=>$column, 'left'=>$left);
		}
		else
		{
			throw new Exception('initialize tranformation with init_transformation');
		}
	}
	public function add_transformation_t($key, $token)
	{
		$texists = array_key_exists($key, $this->m_transformations);
		if ($texists)
		{
			// @TODO test to determine if status is open.
			$this->m_transformations[$key][] = array('type'=>'t','token'=>$token);
		}
		else
		{
			throw new Exception('initialize tranformation with init_transformation');
		}
	}
	public function close_transformation($key)
	{
		$texists = array_key_exists($key, $this->m_transformations);
		if ($texists)
		{
			$this->m_transformations[$key][0] = array('status'=>'closed');
		}
		else
		{
			throw new Exception('initialize tranformation with init_transformation');
		}
	}
	public function process_file()
	{
		syslog(LOG_DEBUG,'process_file');
		$row = 1;
		// Open csv file.
		if (($handle = fopen($this->m_filename, "r")) !== FALSE)
		{
			// Acquire the header.
			if (($data = fgetcsv($handle)) !== FALSE)
			{
				
				$num_afields = count($data);
				$num_efields = count($this->m_expectedfields); 
				if ($num_afields != $num_efields)
				{
					throw new Exception('num_afields='.$num_afields.';num_efields='.$num_efields);
				}
			}
			// Process each line
			while (($data = fgetcsv($handle)) !== FALSE) {
				syslog(LOG_DEBUG,'processing a line');
				$row++;
				if (count($data) != count($this->m_expectedfields))
				{
					syslog(LOG_DEBUG,'...error detected');
					$this->m_errorList[] = array('line'=>$row, 'errorFound'=>'number of fields not correct', 'ignored'=>true);				
					continue;
				}
				$StartTime = $data[0];
				$EndTime = $data[1];
				$Employee = $data[2];
				$Location = $data[3];
				$SKU = $data[4];
				$Quantity = $data[5];
				syslog(LOG_DEBUG,'...Employee='.$Employee);

				// Store total Quantity per Employee.
				// First insure it can be added.
				if (!is_numeric($Quantity))
				{
					$this->m_errorList[] = array('line'=>$row, 'errorFound'=>'Quantity is not numeric', 'ignored'=>true);				
					continue;
				}
				// Second add to current sum total.
				if (array_key_exists($Employee,$this->m_QuantityPerEmployee))
				{
					$this->m_QuantityPerEmployee[$Employee] += intval($Quantity);
				}
				else
				{
					$this->m_QuantityPerEmployee[$Employee] = intval($Quantity);
				}
				// Store Location per Employee.
				if (array_key_exists($Employee,$this->m_EmployeeL))
				{
					$this->m_EmployeeL[$Employee][] = $Location;
				}
				else
				{
					$this->m_EmployeeL[$Employee] = array();
					$this->m_EmployeeL[$Employee][] = $Location;
				}
				// Store StartTime per Employee.
				if (array_key_exists($Employee,$this->m_EmployeeS))
				{

					$this->m_EmployeeS[$Employee][] = $StartTime;
				}
				else
				{
					$this->m_EmployeeS[$Employee] = array();
					$this->m_EmployeeS[$Employee][] = $StartTime;
				}
				// Note: Above Store operations insure aligned order
				// which will be utilized under multisort.
				$row++;
			}
			fclose($handle);
			// Sort the StartTime component and have Location follow.
			foreach ($this->m_EmployeeS as $curEmployee=>$curEmployeeStart)
			{
				array_multisort($this->m_EmployeeS[$curEmployee], $this->m_EmployeeL[$curEmployee]);
			}
		}
		
	}
	/**
	  * employee_start_data: simply prints out info related to employee start data.
	  * This can also be used as an example of how to use the result of get_EmployeeS.
	  */
	public function employee_start_data()
	{
		echo '<p>';
		echo '<p>EMPLOYEE START DATA';
		$es = $this->get_EmployeeS();
		foreach ($es as $key_Employee=>$value_StartTimeArray)
		{
			echo '<p>Employee='.$key_Employee;
			foreach ($value_StartTimeArray as $key=>$value_StartTime)
			{
				echo '<p>...'.$value_StartTime;
			}
		}
		echo '<p>';
	}
	/**
	  * employee_location_data: simply prints out info related to employee location data.
	  * This can also be used as an example of how to use the result of get_EmployeeL.
	  */
	public function employee_location_data()
	{
		echo '<p>';
		echo '<p>EMPLOYEE LOCATION DATA';
		$el = $this->get_EmployeeL();
		foreach ($el as $key_Employee=>$value_LocationArray)
		{
			echo '<p>Employee='.$key_Employee;
			foreach ($value_LocationArray as $key=>$value_Location)
			{
				echo '<p>...'.$value_Location;
			}
		}
		echo '<p>';
	}

	/**
	  * quantity_per_employee: displays the quantity total per employee.
	  * This method also demonstrates how get_QuantityPerEmployee is utilized.
	  */
	public function quantity_per_employee()
	{
		echo '<p>';
		echo '<p>QUANTITY PER EMPLOYEE';
		$qpe = $this->get_QuantityPerEmployee();
		foreach ($qpe as $key_Employee=>$value_Quantity)
		{
			echo '<p>Employee='.$key_Employee;
			echo '<p>...Quantity(total)='.$value_Quantity;
		}
		echo '<p>';
	}
	/**
	  * error_list: displays the errors found in processing the csv file.
	  * This method also shows how get_errorList is utilized.
	  */
	public function error_list()
	{
		echo '<p>';
		echo '<p>ERROR LIST';
		$el = $this->get_errorList();
		foreach ($el as $key=>$value_ErrorArray)
		{
			echo '<p>-------';
			echo '<p>Error:'.$key;
			
	  		$ln = $value_ErrorArray['line'];
			$ef = $value_ErrorArray['errorFound'];
			$ig = $value_ErrorArray['ignored'];

			echo '<p>...line='.$ln;
			echo '<p>...errorFound='.$ef;
			echo '<p>...ignored='.$ig;
		}
		if (count($el) == 0)
		{
			echo '<p>-------';
			echo '<p>...no errors';
		}
		echo '<p>';
	}
}
?>
