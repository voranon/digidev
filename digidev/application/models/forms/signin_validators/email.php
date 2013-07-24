<?php
class dgdev_signinvalidator_email extends Zend_Validate_Abstract{


	const INVALID_FORMAT ='INVALID_FORMAT';
	const NOT_FOUND  	 ='NOT_FOUND';


	public function __construct()
	{


	}

	protected $_messageTemplates = array(
		self::INVALID_FORMAT => "'%value%' has invalid format ",
		self::NOT_FOUND  	 => "'%value%' does not exist in our system",
	);


	public function isValid($value,$context=null){

		$this->_setValue($value);//to insert tested value to the failure message



		if( !preg_match( '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',$value) )
		{
			$this->_error(self::INVALID_FORMAT);
			return false;
		}

		$sql = "select count(*)
				from members
				where username='".$value."'";
		$exist = Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($sql);

		if(!$exist){
			$this->_error(self::NOT_FOUND);
			return false;
		}

		return true;

	}
}
