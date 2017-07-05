<?php

namespace SubscriptionBundle\Entity;

use AuthenticationBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PaymentBundle\Entity\Payment;
use PublicationBundle\Entity\Publication;

/**
 * Subscription
 *
 * @ORM\Table(name="subscription")
 * @ORM\Entity(repositoryClass="SubscriptionBundle\Repository\SubscriptionRepository")
 */
class Subscription
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
     * @var $users User
     *
     * @ORM\ManyToOne(targetEntity="AuthenticationBundle\Entity\User", inversedBy="subscription")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var $publication Publication
     *
     * @ORM\ManyToOne(targetEntity="PublicationBundle\Entity\Publication", inversedBy="subscription")
     * @ORM\JoinColumn(name="publication_id", referencedColumnName="id")
     */
    private $publication;

    /**
     * @var $payment Payment
     *
     * @ORM\OneToMany(targetEntity="PaymentBundle\Entity\Payment", mappedBy="abonnement")
     */
    private $payment;

    /**
     * @var $status boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var $dateStart \DateTime
     *
     * @ORM\Column(name="date_start", type="date")
     */
    private $dateStart;

    /**
     * @var $dateEnd \DateTime
     *
     * @ORM\Column(name="date_end", type="date")
     */
    private $dateEnd;

    function __construct()
    {
        $this->dateStart = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->dateEnd = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        date_modify($this->dateEnd, '+1 year');
        $this->status = true;
        $this->payment = new ArrayCollection();
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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Publication
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * @param Publication $publication
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param Payment $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }


}

