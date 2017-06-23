<?php

namespace AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AuthenticationBundle\Entity\User;

/**
 * ActivationLink
 *
 * @ORM\Table(name="activation_link")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\ActivationLinkRepository")
 */
class ActivationLink
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
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */
    private $user;


    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string")
     */
    private $hash;

    /**
     * @var string
     *
     *
     * @ORM\Column(type="string")
     */
    private $salt;


    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $expirationDate;

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
     * @return User
    */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @param User $user
    */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }


    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
    */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
    */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param mixed $expirationDate
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }




}

