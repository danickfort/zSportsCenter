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
    protected $inputFilter;

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
     * @param string $popOver1
     */
    public function setPopOver1($popOver1) {
        $this->popOver1 = $popOver1;
    }


    /**
     * @param string $popOver2
     */
    public function setPopOver2($popOver2) {
        $this->popOver2 = $popOver2;
    }

    /**
     * @param int $openingHour
     */
    public function setOpeningHour($openingHour) {
        $this->openingHour = $openingHour;
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