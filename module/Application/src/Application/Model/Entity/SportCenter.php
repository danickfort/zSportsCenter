<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="tbl_sport_center")
 *
 * @author matthieu.rossier
 */
 
 class SportCenter
 {
	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
	/** @Column(type="string") * */
	protected $name;
	
	/** @Column(type="string") * */
	protected $adresse;
	
	/** @Column(type="string") * */
	protected $city;
	
	/** @Column(type="integer") * */
	protected $postCode;
	
	/** @Column(type="string") * */
	protected $imagePath;
	
	/** @Column(type="string") * */
	protected $phone;
	
	/** @Column(type="string") * */
	protected $twitter;
	
	/** @Column(type="string") * */
	protected $facebook;
	
	/** @Column(type="integer") * */
	protected $timetableHourStart;
	
	/** @Column(type="integer") * */
	protected $timetableHourEnd;
	
	/**
     * @OneToMany(targetEntity="Holiday", mappedBy="sportCenter")
     * @var Holidays[]
     * */
    protected $holidays;
	
	public function __construct() {
		$this->holidays = new ArrayCollection();
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
    public function getAdresse() {
        return $this->adresse;
    }
    
    /**
     * @param string $adresse
     */
    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }
	
    /**
     * @return string
     */
    public function getCity() {
        return $this->city;
    }
    
    /**
     * @param string $city
     */
    public function setCity($city) {
        $this->city = $city;
    }
	
    /**
     * @return int
     */
    public function getPostCode() {
        return $this->postCode;
    }
    
    /**
     * @param int $postCode
     */
    public function setPostCode($postCode) {
        $this->postCode = $postCode;
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
    public function getPhone() {
        return $this->phone;
    }
    
    /**
     * @param string $phone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }
	
    /**
     * @return string
     */
    public function getTwitter() {
        return $this->twitter;
    }
    
    /**
     * @param string $twitter
     */
    public function setTwitter($twitter) {
        $this->twitter = $twitter;
    }
	
    /**
     * @return string
     */
    public function getFacebook() {
        return $this->facebook;
    }
    
    /**
     * @param string $facebook
     */
    public function setFacebook($facebook) {
        $this->facebook = $facebook;
    }
	
    /**
     * @return int
     */
    public function getTimetableHourStart() {
        return $this->timetableHourStart;
    }
    
    /**
     * @param int $timetableHourStart
     */
    public function setTimetableHourStart($timetableHourStart) {
        $this->timetableHourStart = $timetableHourStart;
    }
	
    /**
     * @return int
     */
    public function getTimetableHourEnd() {
        return $this->timetableHourEnd;
    }
    
    /**
     * @param int $timetableHourEnd
     */
    public function setTimetableHourEnd($timetableHourEnd) {
        $this->timetableHourEnd = $timetableHourEnd;
    }
	
	/**
     * @return ArrayCollection
     */
    public function getHolidays() {
        return $this->holidays;
    }
    
    /**
     * @param ArrayCollection $holidays
     */
    public function setHolidays($holidays) {
        $this->holidays = $holidays;
    }
 }