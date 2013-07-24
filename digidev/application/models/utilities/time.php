<?php



class dgdev_utility_time{

	private function set_timezone(){
		date_default_timezone_set('America/Los_Angeles');
	}

	public static function get_currentdatetime_mysql(){
		static::set_timezone();
		return date('Y-m-d H:i:s');
	}

	public static function get_futuredatetime_mysql($days=0){
		static::set_timezone();
		return date('Y-m-d H:i:s', strtotime(' +'.$days.' day'));
	}

	public static function get_futuredatetime_authorizenet($days=0){
		static::set_timezone();
		return date('Y-m-d', strtotime(' +'.$days.' day'));
	}
}

?>