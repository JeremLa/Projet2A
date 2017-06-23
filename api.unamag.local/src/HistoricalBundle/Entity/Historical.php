<?php

namespace HistoricalBundle\Entity;

use AuthenticationBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Historical
 *
 * @ORM\Table(name="historical")
 * @ORM\Entity(repositoryClass="HistoricalBundle\Repository\HistoricalRepository")
 */
class Historical
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
     * @ORM\Column(name="methode", type="string")
     */
    private $methode;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var User
     *
     * @ORM\ManyToMany(targetEntity="AuthenticationBundle\Entity\User", cascade={"persist"}, )
     */
    private $users;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="Date")
     */
    private $dateCreate;

    public function __construct()
    {
        $this->dateCreate = new \Datetime();
        $this->users = new ArrayCollection();
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

    /**
     * @return string
     */
    public function getMethode()
    {
        return $this->methode;
    }

    /**
     * @param string $methode
     */
    public function setMethode($methode)
    {
        $this->methode = $methode;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    public function removeCategory(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * @return User
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * @param \DateTime $dateCreate
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    }
}

