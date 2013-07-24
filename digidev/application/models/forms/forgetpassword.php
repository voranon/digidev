<?php

class dgdev_form_forgetpassword extends Zend_Form{

	public function __construct($options = null)
	{
		parent::__construct($options);

		$email = new Zend_Form_Element_Text(
					'email',
					array(
						'label'      => 'Enter your email',
						'value'      => '',
						'decorators' => array(
								new forgetpassword_decorator()
											 )
						 )
		);

		$email->setRequired(true);
		$email->addValidator( new DGdev_Signinvalidator_email() );


		$continue = new Zend_Form_Element_Submit(
				'continue',
				array(
						'label'		=> '',
						'value'     => 'Continue',
						'decorators'=> array(
								new forgetpassword_decorator()
						)
				)
		);

		$this->addElements(array($email,$continue));

	}

}

class forgetpassword_decorator extends Zend_Form_Decorator_Abstract
{

	public function __construct($foo=null){

	}
	public function render($content){

		$element = $this->getElement();
		$messages = $element->getMessages();
		$name    = htmlentities($element->getFullyQualifiedName());
		$label   = htmlentities($element->getLabel());
		$id      = htmlentities($element->getId());
		$value   = htmlentities($element->getValue());

		if($name == 'email'){
			$format=" <table border='0' style='margin:0 auto;width:290px'>
    					<tr>
    						<td><input type='text' style='width: 200px' placeholder='%s' name='%s' value='%s'></input></td>
    					</tr>
						<tr>
    						<td>&nbsp;%s</td>
    					</tr>";

			return sprintf($format,$label,$name,$value,reset($messages));

		}else if($name == 'continue'){
			$format="	<tr>
    						<td><input type='submit' value='%s' name='%s'></input></td>
    					</tr>
    					<tr>
    						<td>We will send you an email immediately with new password.</td>
    					</tr>
 					  </table>";

			return sprintf($format,$value,$name);
		}

	}
}

/*

 <table border='0' style='margin:0 auto;width:210px'>
    			<tr>
    				<td><input type='text' style='width: 200px' placeholder='Enter your email'></input></td>
    			</tr>
				<tr>
    				<td>&nbsp;</td>
    			</tr>
    			------------------------
    			<tr>
    				<td><input type='submit' value='Continue'></input></td>
    			</tr>
    			<tr>
    				<td>We will send you an email immediately with new password.</td>
    			</tr>
 </table>

 */






