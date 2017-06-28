<?php
namespace HistoricalBundle\Services;
/**
 * Created by PhpStorm.
 * User: BabyRoger
 * Date: 26/06/2017
 * Time: 13:45
 */
use \Doctrine\ORM\EntityManager;
use  \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HistoricalService
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findOneOr404($id){
        $historical = $this->em->getRepository('HistoricalBundle:Historical')->findOneBy(['id' => $id]);

        if(!$historical){
            throw new NotFoundHttpException('Historical not found for ID : '.$id);
        }

        return $historical;
    }
}