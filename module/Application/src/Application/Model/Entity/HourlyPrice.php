<?php

namespace Application\Model\Entity;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @Entity
 * @Table(name="tbl_hourly_price")
 *
 * @author matthieu.rossier
 */
 
 class HourlyPrice implements InputFilterAwareInterface
 {
    protected $inputFilter;

	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
	/** @Column(type="integer") * */
	protected $startTime;

    /** @Column(type="integer") * */
    protected $stopTime;
	
	/** @Column(type="integer") * */
	protected $hourlyPrice;
	
	/**
	 * @ManyToOne(targetEntity="Court", inversedBy="getHourlyPrices")
	 */
	protected $court;
	
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
     * @return int
     */
    public function getStartTime() {
        return $this->startTime;
    }
    
    /**
     * @param int $startTime
     */
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    /**
     * @return int
     */
    public function getStopTime() {
        return $this->stopTime;
    }
    
    /**
     * @param int $stopTime
     */
    public function setStopTime($stopTime) {
        $this->stopTime = $stopTime;
    }
	
	/**
     * @return int
     */
    public function getHourlyPrice() {
        return $this->hourly_price;
    }
    
    /**
     * @param int $hourly_price
     */
    public function setHourlyPrice($hourly_price) {
        $this->hourly_price = $hourly_price;
    }
	
	/**
     * @return Court
     */
    public function getCourt() {
        return $this->court;
    }
    
    /**
     * @param Court $court
     */
    public function setCourt($court) {
        $this->court = $court;
    }

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->startTime = (isset($data['startTime'])) ? $data['startTime'] : null;
        $this->stopTime = (isset($data['stopTime'])) ? $data['stopTime'] : null;
        $this->hourlyPrice = (isset($data['hourlyPrice'])) ? $data['hourlyPrice'] : null;
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
                'name' => 'startTime',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'stopTime',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'hourlyPrice',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}