<?php
namespace Authentification\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity(repositoryClass="Authentification\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="user_id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(name="user_email")  
     */
    protected $email;
    
    /** 
     * @ORM\Column(name="user_pseudo")  
     */
    protected $pseudo;
    
    /** 
     * @ORM\Column(name="user_full_name")  
     */
    protected $fullName;

    /** 
     * @ORM\Column(name="user_password")  
     */
    protected $password;
    
    /**
     * @ORM\Column(name="user_date_created")  
     */
    protected $dateCreated;
        
    /**
     * @ORM\Column(name="user_token")  
     */
    protected $token;
    
    /**
     * @ORM\Column(name="user_role")  
     */
    protected $role;
    
    /**
     * Returns user ID.
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * Sets user ID. 
     * @param int $id    
     */
    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPseudo() {
        return $this->pseudo;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function getToken() {
        return $this->token;
    }
    
    public function getRole() {
        return $this->role;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function setRole($role) {
        $this->role = $role;
    }
}



