<?php

namespace AuthenticationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HistoricalBundle\Entity\Historical;
use SubscriptionBundle\Entity\Subscription;

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
     * @var int
     *
     * @ORM\Column(name="actif", type="integer", options={"default":1})
     */
    private $actif = 1;


    /**
     * @ORM\ManyToMany(targetEntity="HistoricalBundle\Entity\Historical", mappedBy="users")
     */
    private $historical;

    /**
     * @ORM\OneToMany(targetEntity="SubscriptionBundle\Entity\Subscription", mappedBy="user")
     */
    private $subscription;

    function __construct()
    {
        $this->historical = new ArrayCollection();

        $this->subscription = new ArrayCollection();
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
    public function setAdress($adress)
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
    public function setTel($tel)
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

    /**
     * @return int
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * @param int $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    /**
     * @return mixed
     */

    public function getHistorical()
    {
        return $this->historical;
    }

    /**
     * @param mixed $historical
     */
    public function setHistorical($historical)
    {
        $this->historical = $historical;
    }

    public function addHistorical(Historical $historical)
    {
        $this->historical[] = $historical;

        return $this;
    }

    public function removeHistorical(Historical $historical)
    {
        $this->historical->removeElement($historical);
    }

    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param mixed $subscription
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
    }

    public function addSubscription(Subscription $subscription)
    {
        $this->subscription[] = $subscription;

        return $this;
    }

    public function removeSubscription(Subscription $subscription)
    {
        $this->subscription->removeElement($subscription);
    }

}

