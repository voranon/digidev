<?php

/**
 * TestController
 *
 * @author
 * @version
 */

class TestController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		// TODO Auto-generated TestController::indexAction() default action
		echo 'test';
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}


	public function cdnAction(){

		include APPLICATION_PATH.'/models/CDN/LvpAuthUtil.php';

   		$access_key = "iYVdeJqMHY6UVmLsXpj4dwkSWbc=";
   		$secret 	= "MLbnYwKGhVC3KfB29xz96aWIQQ4=";
   		$org_id 	= "269bd54f3e664564bd80c1a59af524e7";
		$request = "http://api.videoplatform.limelight.com/rest/organizations/$org_id/channelgroups/c3249d4aad6b49ea8f6e5e1af36a71e1/channels.XML";




   		$signed_request = LvpAuthUtil::authenticate_request("GET", $request, $access_key, $secret);
		//echo $signed_request;
   		$ch = curl_init();
   		curl_setopt($ch, CURLOPT_URL, $signed_request);
   		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   		$result = curl_exec($ch);
   		curl_close($ch);


   		$jsonobj = json_decode($result);
   		//print_r($jsonobj->channel_list);
   		foreach( $jsonobj->channel_list as $channel){


   			$params = array("and" => "channel_id:".$channel->channel_id);

   			$request = 'http://api.videoplatform.limelight.com/rest/organizations/'.$org_id .'/media/search';

   			$signed_request = LvpAuthUtil::authenticate_request("GET", $request, $access_key, $secret,$params);
   			//echo $signed_request;
   			$ch = curl_init();
   			curl_setopt($ch, CURLOPT_URL, $signed_request);
   			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   			$result = curl_exec($ch);
   			curl_close($ch);

   			$jsonobj = json_decode($result);

   			print_r($jsonobj);




   		}
   		echo $jsonobj->data_as_of;



   		//print_r($jsonobj);

		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

	}

	public function testrokuAction(){

		$username = $_GET['username'];
		$password = $_GET['password'];

		$post_string='<?xml version="1.0" encoding="utf-8"?>
   					  <DGdevrequest>
      				  	<Username>'.$username.'</Username>
                      	<Password>'.$password.'</Password>
                      </DGdevrequest>';



		$response = DGdev_Utility_xml::postXML('http://zf.digidev.io/rokuxml/authenticate', $post_string);
		echo $response;
		$xml = simplexml_load_string( $response );


		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}
		// testing part1

		// testing part2
	public function test2Action(){
		echo 'test';
		$authorizenet = new DGdev_Utility_authorizenet();

		$data =	$authorizenet->createCustomerARB('non@digidev.com',
				'andrea',
				'chumnansiri',
				'4217661486084239',
				'2014-10',
				'722',
				'927 w college st apt 3',
				'90012',
				DGdev_Utility_time::get_futuredatetime_authorizenet(7),
				'4.99');
		$xml = simplexml_load_string($data);
		echo $xml;
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}

}
