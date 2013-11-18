<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="tbl_court")
 *
 * @author matthieu.rossier
 */
 
 class Court
 {
	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
	/** @Column(type="string") * */
	protected $name;
	
	/** @Column(type="string") * */
	protected $imagePath;
	
	/** @Column(type="string") * */
	protected $description;
	
	/**
	 * @OneToOne(targetEntity="Sport")
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
    public function getImagePath() {
        return $this->imagePath;
    }
    
    /**
     * @param string $imagePath
     */
    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
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
}