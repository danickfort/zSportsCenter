<?php

namespace Application\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('user');
		
		/*$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal');
		$this->setAttribute('class', 'row span6');*/

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		
		$this->add(array(
			'name' => 'nickname',
			'type' => 'Text',
			'options' => array(
				'label' => 'Nickname',
			),
			'attributes' => array(
				'placeholder' => 'Nickname',
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'password',
			'type' => 'Password',
			'options' => array(
				'label' => 'Password',
			),
			'attributes' => array(
				'placeholder' => 'Password',
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'firstName',
			'type' => 'Text',
			'options' => array(
				'label' => 'Firstname',
				),
			'attributes' => array(
				'placeholder' => 'Firstname',
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'lastName',
			'type' => 'Text',
			'options' => array(
				'label' => 'LastName',
			),
			'attributes' => array(
				'placeholder' => 'Lastname',
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'dateOfBirth',
			'type' => 'Date',
			'options' => array(
				'label' => 'Date of birth',
			),
			'attributes' => array(
				'class' => 'date form-control',
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
				'class' => 'form-control',
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
				'class' => 'form-control',
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
				'class' => 'form-control',
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
				'class' => 'form-control',
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