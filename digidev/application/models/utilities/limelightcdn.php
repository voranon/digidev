<?php
include APPLICATION_PATH.'/../public/library/limelight_CDN/LvpAuthUtil.php';

//include APPLICATION_PATH.'/models/CDN/LvpAuthUtil.php';

class dgdev_utility_limelightCDN{

	private $access_key;
	private $secret;
	private $org_id;
	private $result;

	function __construct(){

		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/limelight_cdn.ini','zf1');

		$this->access_key = $config->access_key;
		$this->secret     = $config->secret;
		$this->org_id     = $config->org_id;

	}

	private function json_call($request){
		$signed_request = LvpAuthUtil::authenticate_request("GET", $request, $this->access_key, $this->secret);
		//echo $signed_request;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $signed_request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$this->result = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->result);
	}

	public function get_chennelgroups($chennelgroup_id){
		//c3249d4aad6b49ea8f6e5e1af36a71e1

		$request = 'http://api.videoplatform.limelight.com/rest/organizations/'.$this->org_id.'/channelgroups/'.$chennelgroup_id.'/channels';

		return $this->json_call($request);

	}

	public function get_medias($channel_id){

		$request = 'http://api.videoplatform.limelight.com/rest/organizations/'.$this->org_id.'/channels/'.$channel_id.'/media';

		return $this->json_call($request);

	}

	public function get_media($media_id){
		//f61885d67ae84b6f8332d0252d134559
		$request = 'http://api.videoplatform.limelight.com/rest/organizations/'.$this->org_id.'/media/'.$media_id.'/properties';

		return $this->json_call($request);

	}
	public function test(){
		return 'tests';
	}

}
