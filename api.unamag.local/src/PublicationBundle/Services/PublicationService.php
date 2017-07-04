<?php
namespace PublicationBundle\Services;


use AuthenticationBundle\Entity\User;
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
        $publication = $this->findOneOr404($id);

        return count($publication->getSubscription());
    }

    public function getPublicationByUser(User $user, $limit, $offset, $search){
        $publications = $this->em->getRepository('PublicationBundle:Publication')->getPublicationByUser($user, $limit, $offset, $search);

        return $publications;
    }
}