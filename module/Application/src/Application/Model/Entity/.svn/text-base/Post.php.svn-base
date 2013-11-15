<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @Entity
 * @Table(name="post")
 *
 * @author anthony.mougin
 */
class Post {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
    
    /** @Column(type="date") * */
    protected $date;

    /** @Column(type="string") * */
    protected $title;
    
    /** @Column(type="string") * */
    protected $description;
    
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
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }
    
    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
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
    
}

?>
