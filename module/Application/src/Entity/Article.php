<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="article")
 */

class Article {
    /**
     * @ORM\Id
     * @ORM\Column(name="article_id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Many articles have One theme.
     * @ManyToOne(targetEntity="Theme")
     * @JoinColumn(name="article_theme_id", referencedColumnName="theme_id")
     */
    protected $theme;
    
    /** 
     * @ORM\Column(name="article_title")  
     */
    protected $title;
    
    /** 
     * @ORM\Column(name="article_text")  
     */
    protected $text;

    /** 
     * @ORM\Column(name="article_commentaire")  
     */
    protected $commentaire;
    
    /**
     * @ORM\Column(name="article_user")  
     */
    protected $user;
    
    /**
     * @ORM\Column(name="article_date_created")  
     */
    protected $date_created;


    public function getId() {
        return $this->id;
    }

    public function getTheme() {
        return $this->theme;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getText() {
        return $this->text;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function getUser() {
        return $this->user;
    }
    
    public function getDate_created() {
        return $this->date_created;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setDate_created($date) {
        $this->date_created = $date;
    }

}
