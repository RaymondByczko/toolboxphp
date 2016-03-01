<?php
/*
 * @file newsletter/php/lib/CSignup.php
 * @company self
 * @author Raymond Byczko
 * @start_date 2016-02-27 Feb 27, 2016
 * @purpose A class used to present a form for signup.
 * @change_history 2016-02-27, RByczko, Started this file.
 * @change_history 2016-03-01, RByczko, Added validation
 * with jquery and jquery validation. See:
 * 		http://jqueryvalidation.org/
 * Also documented setids method.
 */
?>
<?php

class CSignup
{
	protected $_action='';
	protected $_method='POST';
	protected $_validation=FALSE;

	/*
	 * @id_section Here we set up ids used as defaults.
	 * These can be reset using: setids.
	 */
	protected $_id_form='SIGNUP_ID';
	protected $_id_signupname='ID_SIGNUPNAME';
	protected $_id_signupemail='ID_SIGNUPEMAIL';

	public function __construct($method, $action)
	{
		$this->_method=$method;
		$this->_action=$action;
	}
	/*
	 * @purpose To allow javascript validation to occur.
	 * It is important to call this with TRUE if javascript
	 * is inserted into the body.
	 */
	public function validation($enabled)
	{
		$this->_validation = $enabled;
	}
	public function style()
	{
?>
<style>
#<?php echo $this->_id_signupname;?> {
	border:2px solid black;
}
#<?php echo $this->_id_signupemail;?> {
	border:2px solid black;
}
</style>
<?php
	}
	/*
	 * @purpose To output script section, to be used in the <body> element etc.
	 */
	public function script()
	{
		if ($this->_validation)
		{
?>
<script src="//code.jquery.com/jquery-1.12.0.min.js">
</script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js">
</script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.js">
</script>
<?php
		}
	}
	public function display()
	{
		$this->_presentForm();
	}
	private function _presentForm()
	{
	
?>
<form
id="<?php echo $this->_id_form;?>"
action="<?php echo $this->_action;?>"
method="<?php echo $this->_method;?>"
>
<label for="fname">Name</label>
<input id="<?php echo $this->_id_signupname;?>" type="text" name="signupname" minlength="2" />
<br></br>
<label for="femail">Email</label>
<input id="<?php echo $this->_id_signupemail;?>" type="email" name="signupemail" />
<br></br>
<input type="submit" value="Sign Up!"/>
</form>
<?php
		if ($this->_validation)
		{
?>
<script>
$("#<?php echo $this->_id_form;?>").validate({
	rules: {
		<?php /*echo $this->_id_signupname;*/?>signupname:"required",	
		<?php /*echo $this->_id_signupemail;*/?>signupemail:"required"	
	},
	messages: {
		signupname:"Two or more!",	
		signupemail:"Need email!"	
	},
	highlight: function(element, errorClass) {
		/*$(element).fadeOut(function() {
		  $(element).fadeIn();
    	});*/
		$(element).css("border","solid 2px red");
	},
	unhighlight: function(element, errorClass) {
		$(element).css("border","solid 2px green");
	},
	submitHandler: function(form) {
		/* this is invoked when the form is finally valid */
		$("<div>Test message</div>").dialog();
	}
});
</script>
<?php
		}
	}
	/*
	 * @purpose To set ids using the associative array give as idarray.
	 * For DOM traversal, its important to set id uniquely.
	 */
	public function setids($idarray)
	{
		$this->_id_signupname	= $idarray['signupname'];	
		$this->_id_signupemail	= $idarray['signupemail'];	
		$this->_id_form			= $idarray['form'];

		// @todo remove
		// $this->_id_signupemail = idarray['_id_'.$idarray['signupemail'];	
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
