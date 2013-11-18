<?php

namespace Application\Model\Entity;

/**
 * @Entity
 * @Table(name="comment")
 *
 * @author anthony.mougin
 */
class Comment {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
    
    /** @Column(type="date") * */
    protected $date;

    /** @Column(type="string") * */
    protected $author;
    
    /** @Column(type="string") * */
    protected $message;
	
	/**
	 * @ManyToOne(targetEntity="Post", inversedBy="getComments")
	 */
	protected $post;
    
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
    public function getAuthor() {
        return $this->title;
    }
    
    /**
     * @param string $title
     */
    public function setAuthor($author) {
        $this->author = $author;
    }
    
    /**
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }
    
    /**
     * @param string $description
     */
    public function setMessage($message) {
        $this->message = $message;
    }
	
	/**
     * @return Post
     */
    public function getPost() {
        return $this->post;
    }
    
    /**
     * @param Post $post
     */
    public function setPost($post) {
        $this->post = $post;
    } 
}

?>
