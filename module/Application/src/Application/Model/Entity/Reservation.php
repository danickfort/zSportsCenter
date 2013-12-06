<?php

namespace Application\Model\Entity;

/**
 * @Entity
 * @Table(name="tbl_reservation")
 *
 * @author matthieu.rossier
 */

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;

class Reservation implements InputFilterAwareInterface
{
    protected $inputFilter;
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="datetime") * */
    protected $startDateTime;

    /** @Column(type="datetime") * */
    protected $endDateTime;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="getReservations")
     */
    protected $user;

    /**
     * @ManyToOne(targetEntity="Court", inversedBy="getReservations")
     */
    protected $court;

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return DateTime
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * @param DateTime $startDateTime
     */
    public function setStartDateTime($startDateTime)
    {
        $this->startDateTime = $startDateTime;
    }

    /**
     * @return DateTime
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * @param DateTime $endDateTime
     */
    public function setEndDateTime($endDateTime)
    {
        $this->endDateTime = $endDateTime;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Court
     */
    public function getCourt()
    {
        return $this->court;
    }

    /**
     * @param Court $court
     */
    public function setCourt($court)
    {
        $this->court = $court;
    }

    /*public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
    }*/

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            /*$inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));*/


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array())
    {
        $this->id = $data['id'];
        $this->startDateTime = isset($data['start']) ? new \DateTime($data['start']) : null;
        $this->endDateTime = isset($data['end']) ? new \DateTime($data['end']) : null;
        // TODO : $this->court AND user to ADD HERE !
    }
}