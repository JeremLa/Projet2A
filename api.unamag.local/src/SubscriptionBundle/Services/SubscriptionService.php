<?php
namespace SubscriptionBundle\Services;

use Doctrine\ORM\EntityManager;
use PaymentBundle\Entity\Payment;
use SubscriptionBundle\Entity\Subscription;
use SubscriptionBundle\SubscriptionBundle;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubscriptionService
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findOneOr404($id)
    {
        $subscription = $this->em->getRepository('SubscriptionBundle:Subscription')->findOneBy(['id' => $id]);
        
        if(!$subscription)
        {
            if($id === null){
                $id = 'null';
            }
            throw new NotFoundHttpException('Subscription not found for id : '.$id.'.');
        }

        return $subscription;
    }

    public function persist(Subscription $subscription, $flush = false)
    {
        $this->em->persist($subscription);

        if($flush){
            $this->em->flush();
        }
    }

    public function flush(){
        $this->em->flush();
    }

    public function extendOneYear(Subscription $subscription){
        $subscription->setDateEnd(clone $subscription->getDateEnd()->modify('+1year'));
    }

    public function findStoppedWithoutRefund(){
        $subscriptions = $this->em->getRepository('SubscriptionBundle:Subscription')->findBy(['status' => false]);
        $arr = [];

        $countNoRefund = 0;
        /** @var  $sub Subscription */
        foreach ($subscriptions as $sub){
            /** @var  $pay Payment */
            foreach ($sub->getPayment() as $pay){
                if($pay->getTransactionId() != null and $pay->getRealAmount() == $pay->getAmount()){
                    $countNoRefund ++;
                }
            }
            if($countNoRefund > 0){
                $arr[] = $sub;
            }
            $countNoRefund = 0;
        }
        return $arr;
    }

    public function findNotPaid(){
        $subscriptions = $this->em->getRepository('SubscriptionBundle:Subscription')->findAll();
        $arr = [];
        $found = false;
        /** @var  $sub Subscription */
        foreach ($subscriptions as $sub){
            /** @var  $pay Payment */
            foreach ($sub->getPayment() as $pay){
                if($pay->getTransactionId() == null){
                    $found = true;
                    break;
                }
            }
            if($found){
                $arr[] = $sub;
            }
            $found = false;
        }
        return $arr;
    }
}