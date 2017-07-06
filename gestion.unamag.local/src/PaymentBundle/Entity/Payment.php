<?php

namespace PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SubscriptionBundle\Entity\Subscription;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity(repositoryClass="PaymentBundle\Repository\PaymentRepository")
 */
class Payment
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $transaction_id;

    /**
     * @var $abonnement Subscription
     *
     * @ORM\ManyToOne(targetEntity="SubscriptionBundle\Entity\Subscription", inversedBy="payment",  cascade={"persist"})
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id")
     */
    private $abonnement;

    /**
     * @var $dateFin \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDeb;

    /**
     * @var $dateFin \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @var $datePayment \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $datePayment;

    /**
     * @var $refund boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $refund = false;

    /**
     * @var $realAmount float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $realAmount;

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
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * @param mixed $transaction_id
     */
    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * @return mixed
     */
    public function getAbonnement()
    {
        return $this->abonnement;
    }

    /**
     * @param mixed $abonnement
     */
    public function setAbonnement($abonnement)
    {
        $this->abonnement = $abonnement;
    }

    /**
     * @return \DateTime
     */
    public function getDateDeb()
    {
        return $this->dateDeb;
    }

    /**
     * @param \DateTime $dateDeb
     */
    public function setDateDeb($dateDeb)
    {
        $this->dateDeb = $dateDeb;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return \DateTime
     */
    public function getDatePayment()
    {
        return $this->datePayment;
    }

    /**
     * @param \DateTime $datePayment
     */
    public function setDatePayment($datePayment)
    {
        $this->datePayment = $datePayment;
    }

    /**
     * @return bool
     */
    public function isRefund()
    {
        return $this->refund;
    }

    /**
     * @param bool $refund
     */
    public function setRefund($refund)
    {
        $this->refund = $refund;
    }

    /**
     * @return float
     */
    public function getRealAmount()
    {
        return $this->realAmount;
    }

    /**
     * @param float $realAmount
     */
    public function setRealAmount($realAmount)
    {
        $this->realAmount = $realAmount;
    }




}

