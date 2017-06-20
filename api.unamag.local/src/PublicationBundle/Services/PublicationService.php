<?php
namespace PublicationBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
}