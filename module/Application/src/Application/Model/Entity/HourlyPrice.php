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
	protected $time;
	
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
    public function getTime() {
        return $this->time;
    }
    
    /**
     * @param int $time
     */
    public function setTime($time) {
        $this->time = $time;
    }
	
	/**
     * @return int
     */
    public function getHourlyPrice() {
        return $this->hourlyPrice;
    }
    
    /**
     * @param int $hourlyPrice
     */
    public function setHourlyPrice($hourlyPrice) {
        $this->hourlyPrice = $hourlyPrice;
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
        $this->startTime = (isset($data['time'])) ? $data['time'] : null;
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