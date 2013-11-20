<?php

namespace Application\Form;

use Zend\Form\Form;

class SportCenterForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('SportCenterForm');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal');

		
		$this->add(array(
			'name' => 'PopOver1',
			'type' => 'Textarea',
			'options' => array(
				'label' => 'change popover 1',
			),
			'attributes' => array(
				'placeholder' => 'PopOver1',
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'PopOver2',
			'type' => 'Textarea',
			'options' => array(
				'label' => 'change popover 2',
			),
			'attributes' => array(
				'placeholder' => 'PopOver2',
				'class' => 'form-control',
			),
		));

		
		$this->add(array(
			'name' => 'openingHour',
			'type' => 'Select',
			'options' => array(
				'label' => 'Opening Hour',
				'value_options' => array(
                             '0' => '3:00',
                             '1' => '4:00',
                             '2' => '5:00',
                             '3' => '6:00',
                             '4' => '7:00',
                             '5' => '8:00',
                             '6' => '9:00',
                             '7' => '10:00',
                             '8' => '11:00',
                             '9' => '12:00',
                             '10' => '13:00',
                             '11' => '14:00',
                             '12' => '15:00',
                             '13' => '16:00',
                             '14' => '17:00',
				),
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'closingHour',
			'type' => 'Select',
			'options' => array(
				'label' => 'Closing Hour',
				'value_options' => array(
                             '0' => '11:00',
                             '1' => '12:00',
                             '2' => '13:00',
                             '3' => '14:00',
                             '4' => '15:00',
                             '5' => '16:00',
                             '6' => '17:00',
                             '7' => '18:00',
                             '8' => '19:00',
                             '9' => '20:00',
                             '10' => '21:00',
                             '11' => '22:00',
                             '12' => '23:00',
                             '13' => '00:00',
                             '14' => '01:00',
				),
				'class' => 'form-control',
			),
		));
		
	
		// Submit button.
		$this->add(array(
			'name' => 'sportsCenterSubmit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'sportsCenterSubmit',
				'class' => 'btn btn-primary',
				),
			));
	}
}