<?php

namespace Application\Form;

use Zend\Form\Form;

class NewSportForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('sport');

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

		// Submit button.
		$this->add(array(
			'name' => 'newSportSubmit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'New Sport',
				'class' => 'btn btn-primary',
				),
			));
	}
}