<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Application\Entity\Theme;

/**
 * This class represents a registered user.
 * @ORM\Entity(repositoryClass="Application\Repository\MediaRepository")
 * @ORM\Table(name="media")
 */

class Media {
    
    /**
     * @ORM\Id
     * @ORM\Column(name="media_id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /** 
     * @ORM\Column(name="media_name")  
     */
    protected $name;
    
    /** 
     * @ORM\Column(name="media_description")  
     */
    protected $description;
    
    /**
     * @ORM\Column(name="media_user_text")  
     */
    protected $user_text;
    
    /**
     * @ORM\Column(name="media_lien")  
     */
    protected $lien;
    
    /**
     * @ORM\Column(name="media_article_id")  
     */
    protected $article_id;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getUser_text() {
        return $this->user_text;
    }

    public function getLien() {
        return $this->lien;
    }

    public function getArticle_id() {
        return $this->article_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setUser_text($user_text) {
        $this->user_text = $user_text;
    }

    public function setLien($lien) {
        $this->lien = $lien;
    }

    public function setArticle_id($article_id) {
        $this->article_id = $article_id;
    }


}
