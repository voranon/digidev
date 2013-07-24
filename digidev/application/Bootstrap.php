<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype()
	{

		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->doctype('HTML5');
		$view->headTitle('DigiDev beta version');

		$view->headLink()->prependStylesheet('/css/global/thelist.css');

		$view->headLink()->appendStylesheet('/css/global/jquery-ui/jquery-ui-1.8.17.custom.css');

		$view->headScript()->prependFile('/js/jquery/jquery-1.8.3.js');

		$view->headScript()->appendFile('/js/jquery/jquery-ui-1.9.2.custom.min.js');


	}

	protected function _initAutoload(){

		$autoLoader2	= Zend_Loader_AutoLoader::getInstance();
		$autoLoader2->registerNamespace('DGdev_');

		$autoLoader = new Zend_Loader_Autoloader_Resource(
														array(
						                                     'basePath'              => APPLICATION_PATH.'/models',
			       			                                 'namespace'             => 'DGdev'
															 )
													 	);



		$autoLoader->addResourceType('models','','Model');
		$autoLoader->addResourceType('utilities','/utilities','utility');
		$autoLoader->addResourceType('forms', '/forms','form');
		$autoLoader->addResourceType('registervalidators','/forms/register_validators','registervalidator');
		$autoLoader->addResourceType('paymentregistervalidators','/forms/paymentregister_validators','paymentregistervalidator');
		$autoLoader->addResourceType('signinvalidators','/forms/signin_validators','signinvalidator');
		$autoLoader->addResourceType('forgetpasswordvalidators', '/forms/forgetpassword_validators','forgetpasswordvalidator');
		$autoLoader->addResourceType('memberupdatevalidators','/forms/memberupdate_validators','memberupdatevalidator');


	}

	protected  function _initDatabase()
	{

		$database = new DGdev_Utility_database();
		Zend_Registry::set('database', $database );
		//Zend_Registry::set('database', new DGdev_Utility_database() );

		Zend_Session::start();

	}

}

