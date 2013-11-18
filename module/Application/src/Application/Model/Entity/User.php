<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @Entity
 * @Table(name="tbl_user")
 *
 * @author matthieu.rossier
 */
 
 class User implements InputFilterAwareInterface
 {
	protected $inputFilter;
	
	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
	/** @Column(type="string") * */
	protected $nickname;
	
	/** @Column(type="string") * */
	protected $password;
	
	/** @Column(type="string") * */
	protected $firstName;
	
	/** @Column(type="string") * */
	protected $lastName;
	
	/** @Column(type="date") * */
	protected $dateOfBirth;
	
	/** @Column(type="string") * */
	protected $address;
	
	/** @Column(type="string") * */
	protected $city;
	
	/** @Column(type="integer") * */
	protected $postCode;
	
	/** @Column(type="string") * */
	protected $phone;

	/** @Column(type="boolean") * */
	protected $administrator;
	
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
    public function getNickname() {
        return $this->nickname;
    }
    
    /**
     * @param string $nickname
     */
    public function setNickname($nickname) {
        $this->nickname = $nickname;
    }
	
	/**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }
    
    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
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
     * @return DateTime
     */
    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }
    
    /**
     * @param DateTime $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
    }
	
    /**
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }
    
    /**
     * @param string $address
     */
    public function setAddress($address) {
        $this->address = $address;
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
     * @return boolean
     */
    public function getAdministrator() {
        return $this->administrator;
    }
    
    /**
     * @param boolean $administrator
     */
    public function setAdministrator($administrator) {
        $this->administrator = $administrator;
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

	public function exchangeArray($data) {
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->nickname = (isset($data['nickname'])) ? $data['nickname'] : null;
		$this->password = (isset($data['password'])) ? $data['password'] : null;
		$this->firstName = (isset($data['firstName'])) ? $data['firstName'] : null;
		$this->lastName = (isset($data['lastName'])) ? $data['lastName'] : null;
		$this->dateOfBirth = (isset($data['dateOfBirth'])) ? new \DateTime($data['dateOfBirth']) : null;
		$this->address  = (isset($data['address'])) ? $data['address'] : null;
		$this->city  = (isset($data['city'])) ? $data['city']  : null;
		$this->postCode  = (isset($data['postCode'])) ? $data['postCode'] : null;
		$this->phone  = (isset($data['phone'])) ? $data['phone'] : null;
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
				'name' => 'nickname',
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
				'name' => 'password',
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
				'name' => 'firstName',
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
				'name' => 'lastName',
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
				'name' => 'dateOfBirth',
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
				'name' => 'address',
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
				'name' => 'city',
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
				'name' => 'postCode',
				'required' => true,
				'validators' => array(
					array(
						'name' => 'Digits',
					),
				),
			));
			
			$inputFilter->add(array(
				'name' => 'phone',
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