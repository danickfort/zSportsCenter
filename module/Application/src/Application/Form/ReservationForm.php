<?php

namespace Application\Form;

use Zend\Form\Form,
    Zend\Form\FormInterface;
use Application\Model\Entity\Reservation;

class ReservationForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('event');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'ts',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'start',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Starting at',
            ),
        ));
        $this->add(array(
            'name' => 'end',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Ending at',
            ),
        ));
    }

    /**
     * Bind an object to the form
     *
     * Ensures the object is populated with validated values.
     *
     * @param  object $object
     * @param  int $flags
     * @return mixed|void
     * @throws Exception\InvalidArgumentException
     */
    public function bind($object, $flags = FormInterface::VALUES_NORMALIZED)
    {

        //$object->title   = $object->name;
        $object->start   = $object->started_at->format('Y-m-d H:i:s');
        $object->end     = $object->ended_at->format('Y-m-d H:i:s');

        return parent::bind($object, $flags);
    }
}