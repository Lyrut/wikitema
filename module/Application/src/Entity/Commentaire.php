<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Application\Entity\Theme;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="commentaire")
 */

class Commentaire {
    /**
     * @ORM\Id
     * @ORM\Column(name="commentaire_id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Many commentaires have One article.
     * @ManyToOne(targetEntity="Article")
     * @JoinColumn(name="commentaire_article_id", referencedColumnName="article_id")
     */
    protected $article;
    
    /**
     * Many commentaires have One user.
     * @ManyToOne(targetEntity="Authentification\Entity\User")
     * @JoinColumn(name="commentaire_user_id", referencedColumnName="user_id")
     */
    protected $user;
    
    /** 
     * @ORM\Column(name="commentaire_text")  
     */
    protected $text;
    
    /**
     * @ORM\Column(name="commentaire_date_created")  
     */
    protected $date_created;
    
    public function getId() {
        return $this->id;
    }

    public function getArticle() {
        return $this->article;
    }

    public function getUser() {
        return $this->user;
    }

    public function getText() {
        return $this->text;
    }

    public function getDate_created() {
        return $this->date_created;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setArticle($article) {
        $this->article = $article;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

}
