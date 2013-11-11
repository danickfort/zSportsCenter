<?php

namespace Application\Model\Entity;

/**
 * @Entity
 * @Table(name="tbl_holiday")
 *
 * @author matthieu.rossier
 */
 
 class Holiday
 {
	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
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
    public function getPost() {
        return $this->sportCenter;
    }
    
    /**
     * @param SportCenter $sportCenter
     */
    public function setPost($sportCenter) {
        $this->sportCenter = $sportCenter;
    } 
 }