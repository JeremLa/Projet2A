<?php
namespace ToolsBundle\Services;


use AuthenticationBundle\Services\UserService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PublicationBundle\Services\PublicationService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\VarDumper\VarDumper;

class SearchService
{
    private $em;
    private $stringService;

    function __construct(EntityManager $em, StringService $stringService)
    {
        $this->em = $em;
        $this->stringService = $stringService;
    }

    public function search(string $searchClass, string $search, $page = 1, $limit = 10)
    {
        switch ($searchClass){
            case 'publication':
                $repo = $this->em->getRepository('PublicationBundle:Publication');
                break;
            case 'user':
                $repo = $this->em->getRepository('AuthenticationBundle:User');
                break;
            default:
                throw new BadRequestHttpException('Search on unknown entity : "'.$searchClass.'"');
        }

        $search = $this->stringService->canonicolize($search);

        $datas = $repo->search($page, $limit, $search);

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($datas) / $limit),
            'paramsRoute' => array()
        );

        return array(
            'datas' => $datas,
            'pagination' => $pagination
        );
    }
}