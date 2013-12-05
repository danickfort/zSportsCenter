<?php

namespace Application\Model\Entity;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @Entity
 * @Table(name="tbl_holiday")
 *
 * @author matthieu.rossier
 */
 
 class Holiday implements InputFilterAwareInterface
 {
    protected $inputFilter;

	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string") * */
    protected $name;
	
    /** @Column(type="date") * */
    protected $startDate;
	
    /** @Column(type="date") * */
    protected $endDate;
	
	/**
	 * @ManyToOne(targetEntity="SportCenter", inversedBy="getHolidays")
	 */
	protected $sportCenter;
	
	public function __construct() {
	
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
     * @return DateTime
     */
    public function getStartDate() {
        return $this->startDate;
    }
    
    /**
     * @param DateTime $startDate
     */
    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }
	
    /**
     * @return DateTime
     */
    public function getEndDate() {
        return $this->endDate;
    }
    
    /**
     * @param DateTime $endDate
     */
    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }
	
	/**
     * @return SportCenter
     */
    public function getSportCenter() {
        return $this->sportCenter;
    }
    
    /**
     * @param SportCenter $sportCenter
     */
    public function setSportCenter($sportCenter) {
        $this->sportCenter = $sportCenter;
    }

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->startDate = (isset($data['startDate'])) ? new \DateTime($data['startDate']) : null;
        $this->endDate = (isset($data['endDate'])) ? new \DateTime($data['endDate']) : null;
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
                'name' => 'startDate',
                'required' => true,
                /*'validators' => array(
                    array(
                        'name' => 'Date',
                        'options' => array(
                            'format' => 'yyyy-MM-dd',
                        ),
                    ),
                ),*/
            ));

            $inputFilter->add(array(
                'name' => 'endDate',
                'required' => true,
                /*'validators' => array(
                    array(
                        'name' => 'Date',
                        'options' => array(
                            'format' => 'yyyy-MM-dd',
                        ),
                    ),
                ),*/
            ));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
 }