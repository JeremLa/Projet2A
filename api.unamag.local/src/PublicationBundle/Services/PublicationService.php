<?php
namespace PublicationBundle\Services;


use Doctrine\ORM\EntityManager;
use PublicationBundle\Entity\Publication;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\VarDumper\VarDumper;

class PublicationService
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findOneOr404($id){
        $publication = $this->em->getRepository('PublicationBundle:Publication')->findOneBy(['id' => $id]);

        if(!$publication){
            throw new NotFoundHttpException('Publication not found for ID : '.$id);
        }

        return $publication;
    }

    public function countSubscription($id){

        return $publication = $this->findOneOr404($id);


        VarDumper::dump($publication);die;

        return count($publication->getSubscription());
    }
}