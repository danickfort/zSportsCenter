<?php

namespace Application\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('user');
		
		$this->add(array(
			'name' => 'firstName',
			'type' => 'Text',
			'options' => array(
				'label' => 'Firstname',
			),
			'attributes' => array(
				'placeholder' => 'Firstname',
				'class' => 'input-medium',
			),
		));
		
		$this->add(array(
			'name' => 'lastName',
			'type' => 'Text',
			'options' => array(
				'label' => 'LastName',
			),
		));
		
		$this->add(array(
			'name' => 'address',
			'type' => 'Text',
			'options' => array(
				'label' => 'Address',
			),
		));
		
		$this->add(array(
			'name' => 'city',
			'type' => 'Text',
			'options' => array(
				'label' => 'City',
			),
		));
		
		$this->add(array(
			'name' => 'postCode',
			'type' => 'Text',
			'options' => array(
				'label' => 'Postcode',
			),
		));
		
		$this->add(array(
			'name' => 'phone',
			'type' => 'Text',
			'options' => array(
				'label' => 'Phone',
			),
		));
		
		// Submit button.
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Sign up',
				'id' => 'submit',
				'class' => 'btn btn-primary',
			),
		));
	}
}