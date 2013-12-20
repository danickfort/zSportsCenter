<?php

namespace Application\Form;

use Zend\Form\Form;

class NewCourtForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('court');

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
			));
		
		$this->add(array(
			'name' => 'name',
			'type' => 'Text',
			'options' => array(
				'label' => 'Name',
				),
			'attributes' => array(
				'placeholder' => 'Name',
				'class' => 'form-control',
				),
			));

		$this->add(array(
			'name' => 'description',
			'type' => 'Textarea',
			'options' => array(
				'label' => 'Description',
				),
			'attributes' => array(
				'placeholder' => 'Description',
				'class' => 'form-control',
				),
			));

		// Submit button.
		$this->add(array(
			'name' => 'newCourtSubmit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'New Court',
				'class' => 'btn btn-primary',
				),
			));

		$this->add(array(
			'name' => 'sport',
			'type' => 'Hidden',
			));
	}
}