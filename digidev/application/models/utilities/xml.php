<?php



class dgdev_utility_xml{

	public function __construct()
	{



	}

	public static function postXML($url,$post_string){

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);

		if(curl_errno($ch))
		{
			echo 'error';
		}else{ // successfull

			return $response;
		}
	}

}

?>