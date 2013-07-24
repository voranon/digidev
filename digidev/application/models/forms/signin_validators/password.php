<?php

class dgdev_signinvalidator_password extends Zend_Validate_Abstract{


	const INVALID 			='INVALID';
	const INACTIVE_CHANNEL  ='INACTIVE_CHANNEL';
	private $register_pate;


	public function __construct()
	{
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/channel.ini','zf1');
		$this->register_page         = $config->register_page;

	}

	protected $_messageTemplates = array(
		self::INVALID 			=> "The password is invalid",
		self::INACTIVE_CHANNEL 	=> "You have to buy this channel"
	);


	public function isValid($value,$context=null){

		$this->_setValue($value);//to insert tested value to the failure message


		$sql="
				select count(*) as exist
				from members
				where username='".$context['email']."'
			";
		$exist = Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($sql);

		if($exist){

			$sql="
					select count(*) as exist
					from members
					where username='".$context['email']."'
					and password = md5('".$value."')
				 ";





			$exist = Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($sql);
			if( !$exist )
			{
				$this->_error(self::INVALID);
				return false;
			}

			$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/channel.ini','zf1');
			$channel_id = $config->db_channel_id;
			$sql="
					select count(*) as exist
					from members m
					inner join member_channel mc on m.member_id = mc.member_id
					where m.username='".$context['email']."'
					and password =  md5('".$value."')
					and mc.channel_id=".$channel_id."
					and mc.member_channel_status=1
					";

			$exist = Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($sql);
			if( !$exist )
			{
				$this->_error(self::INACTIVE_CHANNEL);
				return false;
			}


		}



		return true;

	}
}
?>