<?php
namespace SubscriptionBundle\Services;

use Doctrine\ORM\EntityManager;
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
            $this->flush();
        }
    }

    public function flush(){
        $this->em->flush();
    }
}