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

		$this->add(array(
			'name' => 'twitter',
			'type' => 'Text',
			'options' => array(
				'label' => 'Twitter',
			),
			'attributes' => array(
				'placeholder' => '@Twitter',
				'class' => 'form-control',
			),
		));

		$this->add(array(
			'name' => 'facebook',
			'type' => 'Text',
			'options' => array(
				'label' => 'Facebook',
			),
			'attributes' => array(
				'placeholder' => 'Facebook',
				'class' => 'form-control',
			),
		));

		
		$this->add(array(
			'name' => 'openingHour',
			'type' => 'Select',
			'options' => array(
				'label' => 'Opening Hour',
				'value_options' => array(
                             '3' => '3:00',
                             '4' => '4:00',
                             '5' => '5:00',
                             '6' => '6:00',
                             '7' => '7:00',
                             '8' => '8:00',
                             '9' => '9:00',
                             '10' => '10:00',
                             '11' => '11:00',
                             '12' => '12:00',
                             '13' => '13:00',
                             '14' => '14:00',
                             '15' => '15:00',
                             '16' => '16:00',
                             '17' => '17:00',
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
                             '11' => '11:00',
                             '12' => '12:00',
                             '13' => '13:00',
                             '14' => '14:00',
                             '15' => '15:00',
                             '16' => '16:00',
                             '17' => '17:00',
                             '18' => '18:00',
                             '19' => '19:00',
                             '20' => '20:00',
                             '21' => '21:00',
                             '22' => '22:00',
                             '23' => '23:00',
                             '24' => '00:00',
                             '25' => '01:00',
				),
				'class' => 'form-control',
			),
		));

		$this->add(array(
			'name' => 'defaultHourlyPrice',
			'type' => 'Text',
			'options' => array(
				'label' => 'Default Hourly Price',
			),
			'attributes' => array(
				'placeholder' => 'Default Hourly Price',
				'class' => 'form-control',
			),
		));
	
		// Submit button.
		$this->add(array(
			'name' => 'newSportCenterSubmit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'New sport center',
				'class' => 'btn btn-primary',
			),
		));
	}
}