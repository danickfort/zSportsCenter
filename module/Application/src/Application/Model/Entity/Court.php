<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @Entity
 * @Table(name="tbl_court")
 *
 * @author matthieu.rossier
 */
 
 class Court implements InputFilterAwareInterface
 {
    protected $inputFilter;

	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
	/** @Column(type="string") * */
	protected $name;
	
	/** @Column(type="string") * */
	protected $description;
	
	/**
	 * @ManyToOne(targetEntity="Sport", inversedBy="getCourts")
	 */
	protected $sport;
	
	/**
     * @OneToMany(targetEntity="Reservation", mappedBy="court")
     * @var Reservations[]
     * */
    protected $reservations;
	
	/**
     * @OneToMany(targetEntity="HourlyPrice", mappedBy="court")
     * @var HourlyPrices[]
     * */
    protected $hourlyPrices;
	
	public function __construct() {
		$this->reservations = new ArrayCollection();
		$this->hourlyPrices = new ArrayCollection();
    }
	
	/**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }
	
	/**
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }
	
	/**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }
    
    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }
	
	/**
     * @return Sport
     */
    public function getSport() {
        return $this->sport;
    }
    
    /**
     * @param Sport $sport
     */
    public function setSport($sport) {
        $this->sport = $sport;
    }
	
	/**
     * @return ArrayCollection
     */
    public function getReservations() {
        return $this->reservations;
    }
    
    /**
     * @param ArrayCollection $reservations
     */
    public function setReservations($reservations) {
        $this->reservations = $reservations;
    }
	
	/**
     * @return ArrayCollection
     */
    public function getHourlyPrices() {
        return $this->hourlyPrices;
    }
    
    /**
     * @param ArrayCollection $hourlyPrices
     */
    public function setHourlyPrices($hourlyPrices) {
        $this->hourlyPrices = $hourlyPrices;
    }

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }
    
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'ISO-8859-1',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'description',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'ISO-8859-1',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            ));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}