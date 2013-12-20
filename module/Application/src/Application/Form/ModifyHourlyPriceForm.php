<?php

namespace Application\Form;

use Zend\Form\Form;

class ModifyHourlyPriceForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('modifyHourlyPrice');
		
		$this->setAttribute('method', 'post');
		// $this->setAttribute('class', 'form-horizontal');

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
			));


		$this->add(array(
			'name' => 'hourlyPrice',
			'type' => 'Text',
			// 'options' => array(
				// 'label' => 'Hourly Price',
			// ),
			'attributes' => array(
				'placeholder' => 'Hourly Price',
				'class' => 'form-control',
				),
			));
		
		// Submit button.
		$this->add(array(
			'name' => 'modifyHourlyPriceSubmit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Modify',
				'class' => 'btn btn-primary',
				),
			));
	}
}