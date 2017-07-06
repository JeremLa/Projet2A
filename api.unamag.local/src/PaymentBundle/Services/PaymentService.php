<?php
namespace PaymentBundle\Services;

use Doctrine\ORM\EntityManager;
use PaymentBundle\Entity\Payment;
use SubscriptionBundle\Entity\Subscription;

class PaymentService
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createPayment($dateStart, $dateEnd, Subscription $subscription, $payed = false)
    {
        $payment = new Payment();
        $payment->setDateDeb($dateStart);
        $payment->setDateFin($dateEnd);
        $payment->setAbonnement($subscription);
        $payment->setAmount($subscription->getPublication()->getAnnualCost());
        $payment->setRealAmount($subscription->getPublication()->getAnnualCost());

        if($payed){
            $payment->setTransactionId('string');
            $payment->setDatePayment(new \DateTime('now'));
        }

        $this->em->persist($payment);
        $this->em->flush();
    }
}