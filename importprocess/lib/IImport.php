<?php
/**
  * @file IImport.php
  * @company self
  * @author Raymond Byczko
  * @purpose To specify the interface for an import and process 
  * program.
  */
interface IImport
{
	/**
	  * init: This function initializes the import infrastructure.
	  * This can be:
	  * a) recording the original data structure (e.g. csv, fieldnames)
	  * b) table to hold the original data.
	  */
	public function init();
	/**
	  * load_data: loads the data within filename. The destination
	  * point for the load must be decided by the init implementation.
	  */
	public function load_data($filename);
	/**
	  * init_transformation: this method forms a new virtual column given by $key.
	  * (e.g. 'department').  After this method, the transformation must be
	  * defined using 1 or more add_transformation_* methods.
	   */
	public function init_transformation($key);
	/**
	  * add_transformation: given the virtual column, this method makes
	  * a note as to what real column will be referenced in it, along
	  * with its start and end values.
	  * add_transformation('department' , 'SKU', 0, 1)
	  * This says, to the new virtual column 'department' grab the left most
	  * 2 characters out of the SKU column and make that part of the new
	  * virtual column.
	  */
	public function add_transformation_c($key, $column, $start, $end);
	/**
	  * add_transformation: given a previously created virtual column
	  * this transformation will add a string sequence into the new column.
	  * (e.g. add_transformation('department', '-')
	  */
	public function add_transformation_t($key, $token);
	/**
	  * close_tranformation: this closes or finalizes a transformation
	  * denoted by $key.  No further additions can be made.  It signifies
	  * the end of defining that particular transformation.
	  */
	public function close_transformation($key);
	/**
	  * apply_transformation: this method will consider all closed transformation
	  * and build up the necessary infrastructure to support the new virtual columns.
	  */
	public function apply_transformation();
	/**
	  * delete_transformation: if by chance a mistake (e.g. a runtime exception) is
	  * detected in building a transformation, it can be deleted, so that it will not
	  * be considered by apply_transformation.
	  *
	  */
	public function delete_transformation($key);

}
?>
