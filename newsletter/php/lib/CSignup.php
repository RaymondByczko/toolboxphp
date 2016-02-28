<?php
/*
 * @file newsletter/php/lib/CSignup.php
 * @company self
 * @author Raymond Byczko
 * @start_date 2016-02-27 Feb 27, 2016
 * @purpose A class used to present a form for signup.
 * @change_history 2016-02-27, RByczko, Started this file.
 */
?>
<?php

class CSignup
{
	protected $_action='';
	protected $_method='POST';

	protected $_id_signupname='ID_SIGNUPNAME';
	protected $_id_signupemail='ID_SIGNUPEMAIL';

	public function __construct($method, $action)
	{
		$this->_method=$method;
		$this->_action=$action;
	}
	public function validation($enabled)
	{
	}
	public function style()
	{
?>
<style>
#<?php echo $this->_id_signupname;?> {
	border:2px solid green;
}
#<?php echo $this->_id_signupemail;?> {
	border:2px solid green;
}
</style>
<?php
	}
	public function display()
	{
		$this->_presentForm();
	}
	private function _presentForm()
	{
	
?>
<form
action="<?php echo $this->_action;?>"
method="<?php echo $this->_method;?>"
>
Name
<input id="<?php echo $this->_id_signupname;?>" type="text" name="signupname" />
<br></br>
Email
<input id="<?php echo $this->_id_signupemail;?>" type="text" name="signupemail" />
<br></br>
<input type="submit" value="Sign Up!"/>
</form>
<?php
	}
	public function setids($idarray)
	{
		$this->_id_signupname = $idarray['signupname'];	
		// $this->_id_signupemail = idarray['_id_'.$idarray['signupemail'];	
		$this->_id_signupemail = $idarray['signupemail'];	
	}
	/*
	 * @purpose To get the form names expected as GET or POST variables after
	 * a form has been submitted and when an action is called to process those
	 * form variables.
	 */
	public function getFormNames()
	{
		$formNames = array();
		$formNames[] = 'signupname';
		$formNames[] = 'signupemail';
		return $formNames;
	}
	
}
?>
