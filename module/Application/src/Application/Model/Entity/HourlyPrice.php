<?php

namespace Application\Model\Entity;

/**
 * @Entity
 * @Table(name="tbl_hourly_price")
 *
 * @author matthieu.rossier
 */
 
 class HourlyPrice
 {
	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
	/** @Column(type="integer") * */
	protected $time;
	
	/** @Column(type="integer") * */
	protected $hourly_price;
	
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
}