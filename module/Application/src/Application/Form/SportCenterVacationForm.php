<?php

namespace Application\Form;

use Zend\Form\Form;

class SportCenterVacationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('sportCenterVacationForm');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal');

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));

		$this->add(array(
			'name' => 'name',
			'type' => 'Text',
			'options' => array(
				'label' => 'Vacation Name',
			),
			'attributes' => array(
				'placeholder' => 'Vacation Name',
				'class' => 'form-control',
			),
		));

		$this->add(array(
			'name' => 'startDate',
			'type' => 'Date',
			'options' => array(
				'label' => 'Start Date',
			),
			'attributes' => array(
				'class' => 'date form-control',
			),
		));

		$this->add(array(
			'name' => 'endDate',
			'type' => 'Date',
			'options' => array(
				'label' => 'Stop Date',
			),
			'attributes' => array(
				'class' => 'date form-control',
			),
		));
	
		// Submit button.
		$this->add(array(
			'name' => 'sportCenterVacationSubmit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Set vacation',
				'class' => 'btn btn-primary',
			),
		));

		$this->add(array(
			'name' => 'sportCenter',
			'type' => 'Hidden',
		));
	}
}