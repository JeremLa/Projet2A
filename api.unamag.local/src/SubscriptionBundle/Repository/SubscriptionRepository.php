<?php

namespace SubscriptionBundle\Repository;

use AuthenticationBundle\Entity\User;
class SubscriptionRepository extends \Doctrine\ORM\EntityRepository
{
    public function getInProgressUserSubscription(User $user)
    {
        $query = $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('s')
                    ->from('SubscriptionBundle:Subscription', 's')
                    ->where('s.user = :user AND s.dateEnd <= NOW()')
                    ->getQuery()
                    ->getResult();

        return $query;
    }

    public function getExpiredUserSubscription(User $user)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('s')
            ->from('SubscriptionBundle:Subscription', 's')
            ->where('s.user = :user AND s.dateEnd > NOW()')
            ->getQuery()
            ->getResult();

        return $query;
    }
}
