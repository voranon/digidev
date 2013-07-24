<?php

class dgdev_registervalidator_cpassword extends Zend_Validate_Abstract{


	const MISS_MATCH ='MISS_MATCH';


	public function __construct()
	{


	}

	protected $_messageTemplates = array(
		self::MISS_MATCH => "The password is miss match",
	);


	public function isValid($value,$context=null){

		$this->_setValue($value);//to insert tested value to the failure message



		if( $value != $context['password'] )
		{
			$this->_error(self::MISS_MATCH);
			return false;
		}

		return true;

	}
}
?>