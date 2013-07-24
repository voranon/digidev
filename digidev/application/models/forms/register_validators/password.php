<?php

class dgdev_registervalidator_password extends Zend_Validate_Abstract{


	const TOO_SHORT ='TOO_SHORT';


	public function __construct()
	{


	}

	protected $_messageTemplates = array(
		self::TOO_SHORT => "The password is too short",
	);


	public function isValid($value,$context=null){

		$this->_setValue($value);//to insert tested value to the failure message



		if( strlen($value) < 5 )
		{
			$this->_error(self::TOO_SHORT);
			return false;
		}

		return true;

	}
}
?>