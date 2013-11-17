<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="tbl_user")
 *
 * @author matthieu.rossier
 */
 
 class User
 {
	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
	/** @Column(type="string") * */
	protected $firstName;
	
	/** @Column(type="string") * */
	protected $lastName;
	
	/** @Column(type="string") * */
	protected $adresse;
	
	/** @Column(type="string") * */
	protected $city;
	
	/** @Column(type="integer") * */
	protected $postCode;
	
	/** @Column(type="string") * */
	protected $phone;
	
	/**
     * @OneToMany(targetEntity="Reservation", mappedBy="user")
     * @var Reservations[]
     * */
    protected $reservations;
    
    public function __construct() {
		$this->reservations = new ArrayCollection();
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
    public function getFirstName() {
        return $this->firstName;
    }
    
    /**
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
	
	/**
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }
    
    /**
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
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
}