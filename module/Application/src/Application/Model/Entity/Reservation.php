<?php

namespace Application\Model\Entity;

/**
 * @Entity
 * @Table(name="tbl_reservation")
 *
 * @author matthieu.rossier
 */
 
 class Reservation
 {
	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
    /** @Column(type="date") * */
    protected $date;
	
	/** @Column(type="integer") * */
    protected $startHour;
	
    /** @Column(type="integer") * */
    protected $endHour;
	
	/**
	 * @ManyToOne(targetEntity="User", inversedBy="getReservations")
	 */
	protected $user;
	
	/**
	 * @ManyToOne(targetEntity="Court", inversedBy="getReservations")
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
     * @return DateTime
     */
    public function getDate() {
        return $this->date;
    }
    
    /**
     * @param DateTime $date
     */
    public function setDate($date) {
        $this->date = $date;
    }
	
	/**
     * @return int
     */
    public function getStartHour() {
        return $this->startHour;
    }
    
    /**
     * @param int $startHour
     */
    public function setStartHour($startHour) {
        $this->startHour = $startHour;
    }
	
	/**
     * @return int
     */
    public function getEndHour() {
        return $this->id;
    }
    
    /**
     * @param int $endHour
     */
    public function setEndHour($endHour) {
        $this->endHour = $endHour;
    }
	
	/**
     * @return User
     */
    public function getUser() {
        return $this->user;
    }
    
    /**
     * @param User $user
     */
    public function setUser($user) {
        $this->user = $user;
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