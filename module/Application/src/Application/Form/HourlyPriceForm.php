<?php

namespace Application\Form;

use Zend\Form\Form;

class HourlyPriceForm extends Form
{
	public function __construct($name = null, $timeStart, $timeStop)
	{
		parent::__construct('hourlyPriceForm');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal');

		// generate select input
		$valuesOptions = array();
		for ($i = $timeStart; $i <= $timeStop; $i++) {
			$valuesOptions[strval($i)] = "$i:00";
		}

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));

		$this->add(array(
			'name' => 'startTime',
			'type' => 'Select',
			'options' => array(
				'label' => 'Start Time',
				'value_options' => $valuesOptions,
				'class' => 'form-control',
			),
		));

		$this->add(array(
			'name' => 'stopTime',
			'type' => 'Select',
			'options' => array(
				'label' => 'Stop Time',
				'value_options' => $valuesOptions,
				'class' => 'form-control',
			),
		));


		$this->add(array(
			'name' => 'hourlyPrice',
			'type' => 'Text',
			'options' => array(
				'label' => 'Hourly Price',
			),
			'attributes' => array(
				'placeholder' => 'Hourly Price',
				'class' => 'form-control',
			),
		));
	
		// Submit button.
		$this->add(array(
			'name' => 'hourlyPriceSubmit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Set hourly price',
				'class' => 'btn btn-primary',
			),
		));

		$this->add(array(
			'name' => 'court',
			'type' => 'Hidden',
		));
	}
}