<?php

namespace AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;
use FOS\UserBundle\Model\User as BaseUser;


class User implements UserInterface, AdvancedUserInterface
{
    private $id;
    private $firstname;
    private $lastname;
    private $adress;
    private $city;
    private $zipCode;
    private $tel;
    private $mail;
    private $password;
    private $birthCity;
    private $birthDate;
    private $level;

    function __construct()
    {
//        $date = new \DateTime('now', new \DateTimeZone('europe/paris'));
//        $this->birthDate = $date->format('Y-m-d');
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param string $adress
     */
    public function setAdress(string $adress)
    {
        $this->adress = $adress;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     */
    public function setTel(string $tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getBirthCity()
    {
        return $this->birthCity;
    }

    /**
     * @param string $birthCity
     */
    public function setBirthCity(string $birthCity)
    {
        $this->birthCity = $birthCity;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate(string $birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }


    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->mail;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function isAccountNonExpired()
    {
        return true;
        // TODO: Implement isAccountNonExpired() method.
    }

    public function isAccountNonLocked()
    {
        return true;
        // TODO: Implement isAccountNonLocked() method.
    }

    public function isCredentialsNonExpired()
    {
        return true;
        // TODO: Implement isCredentialsNonExpired() method.
    }

    public function isEnabled()
    {
        return true;
    }
}

