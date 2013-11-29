<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @Entity
 * @Table(name="tbl_sport_center")
 *
 * @author matthieu.rossier
 */
 
 class SportCenter implements InputFilterAwareInterface
 {
    protected $inputFilter;

	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
	/** @Column(type="string") * */
	protected $name;
	
	/** @Column(type="string") * */
	protected $address;
	
	/** @Column(type="string") * */
	protected $city;
	
	/** @Column(type="integer") * */
	protected $postCode;
	
	/** @Column(type="string") * */
	protected $phone;
	
	/** @Column(type="string") * */
	protected $twitter;
	
	/** @Column(type="string") * */
	protected $facebook;

    /** @Column(type="string") * */
    protected $popOver1;

    /** @Column(type="string") * */
    protected $popOver2;

    /** @Column(type="integer") * */
    protected $openingHour;

    /** @Column(type="integer") * */
    protected $closingHour;

	
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
     * @return string
     */
    public function getPopOver1() {
        return $this->popOver1;
    }

    /**
     * @param string $popOver1
     */
    public function setPopOver1($popOver1) {
        $this->popOver1 = $popOver1;
    }

    /**
     * @return string
     */
    public function getPopOver2() {
        return $this->popOver2;
    }


    /**
     * @param string $popOver2
     */
    public function setPopOver2($popOver2) {
        $this->popOver2 = $popOver2;
    }

    /**
     * @return int
     */
    public function getOpeningHour() {
        return $this->openingHour;
    }

    /**
     * @param int $openingHour
     */
    public function setOpeningHour($openingHour) {
        $this->openingHour = $openingHour;
    }

    /**
     * @return int
     */
    public function getClosingHour() {
        return $this->closingHour;
    }

    /**
     * @param int $closingHour
     */
    public function setClosingHour($closingHour) {
        $this->closingHour = $closingHour;
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

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->address = (isset($data['address'])) ? $data['address'] : null;
        $this->city = (isset($data['city'])) ? $data['city'] : null;
        $this->postCode = (isset($data['postCode'])) ? $data['postCode'] : null;
        $this->phone = (isset($data['phone'])) ? $data['phone'] : null;
        $this->twitter = (isset($data['twitter'])) ? $data['name'] : null;
        $this->facebook = (isset($data['facebook'])) ? $data['facebook'] : null;
        $this->popOver1 = (isset($data['popOver1'])) ? $data['popOver1'] : null;
        $this->popOver2 = (isset($data['popOver2'])) ? $data['popOver2'] : null;
        $this->openingHour = (isset($data['openingHour'])) ? $data['openingHour'] : null;
        $this->closingHour = (isset($data['closingHour'])) ? $data['closingHour'] : null;
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

            $inputFilter->add(array(
                'name' => 'twitter',
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
                'name' => 'facebook',
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
                'name' => 'popOver1',
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
                'name' => 'popOver2',
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
                'name' => 'openingHour',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Digits',
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'closingHour',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Digits',
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }

 }