<?php
/**
  * @file Model.php
  * @company self
  * @author Raymond Byczko
  * @start_date 2013-02-?? February 2013
  * @change_log 2013-03-04 March 4, 2013; RByczko; Added comments in
  * preparation to put into git.
  */

App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
	public $validate = array(
		'username'=> array(
			'required'=> array(
				'rule'=> array('notEmpty'),
				'message'=> 'A username is required'
			)
		),
		'password' => array(
			'required'=> array(
				'rule'=> array('notEmpty'),
				'message'=> 'A password is required'
			)
		),
		'role' => array(
			'valid'=> array(
				'rule'=> array('inList', array('admin', 'author')),
				'message'=> 'Please enter a valid role',
				'allowEmpty' => false
			)
		)
	);
	
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
}

?>
