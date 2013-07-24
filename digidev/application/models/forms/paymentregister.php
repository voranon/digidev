<?php

class dgdev_form_paymentregister extends Zend_Form{

	public function __construct($options = null,$email = null)
	{
		parent::__construct($options);

		$email     = new Zend_Form_Element_Text(
					 'email',
					 array(
							'label'		=> '',
							'value' 	=> $email,
							'decorators'=> array(
									new paymentregister_decorator()
												)
						  )
					 );


		$firstname = new Zend_Form_Element_Text(
				'firstname',
				array(
						'label'      => '',
						'value'      => '',
						'decorators' => array(
								new paymentregister_decorator()
						)
				)
		);
		$firstname->setRequired(true);

		$lastname = new Zend_Form_Element_Text(
				'lastname',
				array(
						'label'      => '',
						'value'      => '',
						'decorators' => array(
								new paymentregister_decorator()
						)
				)
		);
		$lastname->setRequired(true);

		$address = new Zend_Form_Element_Text(
				'address',
				array(
						'label'      => '',
						'value'      => '',
						'decorators' => array(
								new paymentregister_decorator()
						)
				)
		);
		$address->setRequired(true);

		$zipcode = new Zend_Form_Element_Text(
				'zipcode',
				array(
						'label'      => '',
						'value'      => '',
						'decorators' => array(
								new paymentregister_decorator()
						)
				)
		);
		$zipcode->setRequired(true);

		$cardnumber = new Zend_Form_Element_Text(
				'cardnumber',
				array(
						'label'      => '',
						'value'      => '',
						'decorators' => array(
								new paymentregister_decorator()
						)
				)
		);
		$cardnumber->setRequired(true);

		$cardnumber->addValidator( new DGdev_Paymentregistervalidator_cardnumber() );


		$seccode = new Zend_Form_Element_Text(
				'seccode',
				array(
						'label'      => '',
						'value'      => '',
						'decorators' => array(
								new paymentregister_decorator()
						)
				)
		);
		$seccode->setRequired(true);

		$month   = new Zend_Form_Element_Select(
					'month',
					array(
							'label'      => '',
							'value'      => '',
							'decorators' => array(
								new paymentregister_decorator()
							)
					)
		);
		$month->setRegisterInArrayValidator(false);

		$year   = new Zend_Form_Element_Select(
				'year',
				array(
						'label'      => '',
						'value'      => '',
						'decorators' => array(
								new paymentregister_decorator()
						)
				)
		);
		$year->setRegisterInArrayValidator(false);

		$start = new Zend_Form_Element_Submit(
				'start',
				array(
						'label'		=> '',
						'value'     => 'Start membership',
						'decorators'=> array(
								new paymentregister_decorator()
						)
				)
		);

		$this->addElements(array($email,$firstname,$lastname,$address,$zipcode,$cardnumber,$seccode,$month,$year,$start));


	}
}

class paymentregister_decorator extends Zend_Form_Decorator_Abstract
{

	private $database;

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
			$format="
					<input type='hidden' name='%s' value='%s'></input>
					";
			return sprintf($format,$name,$value);

		}else if($name == 'firstname'){
			$format="
					<table>
				  		<tr>
				  			<td>
				  				<table>
				  					<tr><td>%s</td></tr>
				  					<tr><td><input type='text' name='%s' value='%s' style='width: 200px;height: 25px;font-size: 20px' placeholder='First name'></input></td></tr>
				  				</table>
				  			</td>";

			return sprintf($format,reset($messages),$name,$value);

		}else if($name == 'lastname'){
			$format="		<td>
  								<table>
  									<tr><td>%s</td></tr>
  									<tr><td><input type='text' name='%s' value='%s' style='width: 200px;height: 25px;font-size: 20px' placeholder='Last name'></input></td></tr>
  								</table>
  							</td>
  						</tr>";
			return sprintf($format,reset($messages),$name,$value);
		}else if($name == 'address'){
			$format="
						<tr><td colspan='2'>%s</td></tr>
  						<tr>
  							<td colspan='2'>
  								<table>
  									<tr>
  									<td><input type='text' name='%s' value='%s' style='width: 400px;height: 25px;font-size: 20px' placeholder='Address'></input></td>
  									</tr>
  								</table>
  							</td>
  						</tr>

					";
			return sprintf($format,reset($messages),$name,$value);
		}else if($name == 'zipcode'){
			$format="
						<tr><td colspan='2'>%s</td></tr>
  						<tr>
  							<td colspan='2'>
  								<table>
  									<tr>
  									<td><input type='text' name='%s' value='%s' style='width: 200px;height: 25px;font-size: 20px' placeholder='Zip Code'></input></td>
  									</tr>
  								</table>
  							</td>
  						</tr>
  						<tr>
  							<td colspan='2'><img src='/images/cards.png'></img></td>
  						</tr>
  					</table>
					";
			return sprintf($format,reset($messages),$name,$value);
		}else if($name == 'cardnumber'){
			$format="
					<div style='margin-top: 10px'>
  						<table style='width:500px'>
  						<tr>
  							<td>
  								<table>
  									<tr><td>&nbsp;%s</td></tr>
  									<tr><td><input type='text' name='%s' value='%s' style='width: 230px;height: 25px;font-size: 20px' placeholder='Card Number'></input></td></tr>
  								</table>
  							</td>
					";
			return sprintf($format,reset($messages),$name,$value);
		}else if($name == 'seccode'){
			$format="
							<td>
  								<table>
  									<tr><td>&nbsp;%s</td></tr>
  									<tr><td><input type='text' name='%s' value='%s' style='width: 230px;height: 25px;font-size: 20px' placeholder='Security Code'></input></td></tr>
  								</table>
  							</td>
  						</tr>
  						</table>
  					</div>
					";
			return sprintf($format,reset($messages),$name,$value);
		}else if($name == 'month'){
			$format="
					<div style='margin-top: 10px'>
  						Expires:<select name='%s' value='%s' style='width: 100px;height: 20px;font-size: 20px'>
  									<option value='01'>Jan (1)</option>
  									<option value='02'>Feb (2)</option>
  									<option value='03'>Mar (3)</option>
  									<option value='04'>Apr (4)</option>
  									<option value='05'>May (5)</option>
  									<option value='06'>Jun (6)</option>
  									<option value='07'>Jul (7)</option>
  									<option value='08'>Aug (8)</option>
  									<option value='09'>Sep (9)</option>
  									<option value='10'>Oct (10)</option>
  									<option value='11'>Nov (11)</option>
  									<option value='12'>Dec (12)</option>
  								</select>
					";
			return sprintf($format,$name,$value);
		}else if($name == 'year'){

            $year = date('Y');
			$format="
								<select name='%s' value='%s' style='width: 100px;height: 20px;font-size: 20px'>";

								for($i=0; $i < 10; $i++){

									$format.="<option value='".$year."'>".$year."</option>";
									$year++;
								}

  			$format.="			</select>
  					</div>
					";
			return sprintf($format,$name,$value);
		}else if($name == 'start'){
			$format="
					<div style='margin-top:20px'>
  						<input type='submit' name='%s' style='width: 257px;height: 90px;font-size: 20px' value='%s'></input>
  					</div>
					";
			return sprintf($format,$name,$value);
		}
	}
}


/*

	<table>
  		<tr>
  			<td>
  				<table>
  					<tr><td>&nbsp;</td></tr>
  					<tr><td><input type='text' name='%s' style='width: 200px;height: 25px;font-size: 20px' placeholder="First name"></input></td></tr>
  				</table>
  			</td>
  			---------------
  			<td>
  				<table>
  					<tr><td>&nbsp;</td></tr>
  					<tr><td><input type='text' name='%s' style='width: 200px;height: 25px;font-size: 20px' placeholder="Last name"></input></td></tr>
  				</table>
  			</td>
  		</tr>

------------------------

  		<tr><td colspan='2'>&nbsp;</td></tr>
  		<tr>
  			<td colspan='2'>
  				<table>
  					<tr>
  						<td><input type='text' name='%s' style='width: 200px;height: 25px;font-size: 20px' placeholder="Zip Code"></input></td>
  					</tr>
  				</table>
  			</td>
  		</tr>
  		<tr>
  			<td colspan='2'>VISA | Master | American express | Discover</td>
  		</tr>
  	</table>

 --------------------------

  	<div style='margin-top: 10px'>
  		<table style='width:500px'>

  			<tr>
  				<td>
  					<table>
  						<tr><td>&nbsp;</td></tr>
  						<tr><td><input type='text' name='%s' style='width: 230px;height: 25px;font-size: 20px' placeholder="Card Number"></input></td></tr>
  					</table>
  				</td>

 ---------------------------

  				<td>
  					<table>
  						<tr><td>&nbsp;</td></tr>
  						<tr><td><input type='text' name='%s' style='width: 230px;height: 25px;font-size: 20px' placeholder="Security Code"></input></td></tr>
  					</table>
  				</td>
  			</tr>

  		</table>


  	</div>


  	------------------------------
	<div style='margin-top: 10px'>
  		Expires:<select name='%s' style='width: 100px;height: 25px;font-size: 20px'>
  					<option value='1'>Jan (1)</option>
  					<option value='2'>Feb (2)</option>
  					<option value='3'>Mar (3)</option>
  					<option value='4'>Apr (4)</option>
  					<option value='5'>May (5)</option>
  					<option value='6'>Jun (6)</option>
  					<option value='7'>Jul (7)</option>
  					<option value='8'>Aug (8)</option>
  					<option value='9'>Sep (9)</option>
  					<option value='10'>Oct (10)</option>
  					<option value='11'>Nov (11)</option>
  					<option value='12'>Dec (12)</option>
  				</select>

	--------------------------------

  				<select name='%s' style='width: 100px;height: 25px;font-size: 20px'>
  					<option value='2012'>2012</option>
  					<option value='2013'>2013</option>
  					<option value='2014'>2014</option>
  				</select>


  	</div>
  	------------------
  	<div style='margin-top:20px'>
  		<input type='submit' name='%s' style='width: 257px;height: 90px;font-size: 20px' value='Start Membership'></input>
  	</div>
*/




