<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @Entity
 * @Table(name="tbl_sport")
 *
 * @author matthieu.rossier
 */
 
 class Sport implements InputFilterAwareInterface
 {
    protected $inputFilter;

	/** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
	
	/** @Column(type="string") * */
	protected $name;

    /**
     * @OneToMany(targetEntity="Court", mappedBy="sport")
     * @var Courts[]
     * */
    protected $courts;
	
	public function __construct() {
        $this->courts = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getCourts() {
        return $this->courts;
    }
    
    /**
     * @param ArrayCollection $courts
     */
    public function setCourts($courts) {
        $this->courts = $courts;
    }

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
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
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}