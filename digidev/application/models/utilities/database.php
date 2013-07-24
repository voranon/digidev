<?php
require_once ('Zend/Db.php');
class dgdev_utility_database
{

	private $dgdev_adapter;


	function __construct ()
	{


		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/database.ini','zf1');
		$info = array(
				'host'      => $config->db->host,
				'username'  => $config->db->username,
				'password'  => $config->db->password,
				'dbname'    => $config->db->dbname,
		);

		$this->dgdev_adapter = Zend_Db::factory($config->db->adapter, $info);

	}

	public function get_dgdev_adapter(){
		return $this->dgdev_adapter;
	}


}