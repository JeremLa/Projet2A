<?php

namespace AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * User
 *
 * @ORM\Table(name="entity_user")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string")
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="canonical_fullname", type="string", nullable=true)
     */
    private $canonicalFullname;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string")
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string")
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=10)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string")
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="birthCity", type="string")
     */
    private $birthCity;

    /**
     * @var string
     *
     * @ORM\Column(name="birthDate", type="string")
     */
    private $birthDate;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function  setId( $id){
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
    public function setFirstname( $firstname)
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
    public function setLastname( $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getCanonicalFullname()
    {
        return $this->canonicalFullname;
    }

    /**
     * @param string $canonicalFullname
     */
    public function setCanonicalFullname($canonicalFullname)
    {
        $this->canonicalFullname = $canonicalFullname;
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
    public function setCity( $city)
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
    public function setMail($mail)
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
    public function setBirthCity($birthCity)
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
    public function setBirthDate($birthDate)
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
}

