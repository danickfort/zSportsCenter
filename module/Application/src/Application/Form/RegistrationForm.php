<?php

namespace Application\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('user');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal');
		$this->setAttribute('class', 'row span6');

		$this->add(array(
			'name' => 'firstName',
			'type' => 'Text',
			'options' => array(
				'label' => 'Firstname',
				),
			'attributes' => array(
				'placeholder' => 'Firstname',
				'class' => 'form-control',
				'id' => 'fname',
				),
			));
		
		$this->add(array(
			'name' => 'lastName',
			'type' => 'Text',
			'options' => array(
				'label' => 'LastName',
				),
			'attributes' => array(
				'placeholder' => 'LastName',
				'class' => 'form-control',
				'id' => 'lname',
				),
			));
		
		$this->add(array(
			'name' => 'address',
			'type' => 'Text',
			'options' => array(
				'label' => 'Address',
				),
			'attributes' => array(
				'placeholder' => 'Address',
				'class' => 'input-medium',
				'class' => 'form-control',
				'id' => 'address',
				),
			));
		
		$this->add(array(
			'name' => 'city',
			'type' => 'Text',
			'options' => array(
				'label' => 'City',
				),
			'attributes' => array(
				'placeholder' => 'City',
				'class' => 'input-medium',
				'class' => 'form-control',
				'id' => 'city',
				),
			));
		
		$this->add(array(
			'name' => 'postCode',
			'type' => 'Text',
			'options' => array(
				'label' => 'Postcode',
				),
			'attributes' => array(
				'placeholder' => 'Postcode',
				'class' => 'input-medium',
				'class' => 'form-control',
				'id' => 'postcode',
				),
			));
		
		$this->add(array(
			'name' => 'phone',
			'type' => 'Text',
			'options' => array(
				'label' => 'Phone',
				),
			'attributes' => array(
				'placeholder' => 'Phone',
				'class' => 'input-medium',
				'class' => 'form-control',
				'id' => 'phone',
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
				'id' => 'submit',
				),
			));
	}
}