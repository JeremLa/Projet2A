<?php
namespace ToolsBundle\Services;


use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\VarDumper\VarDumper;

class SearchService
{
    private $templating;

    function __construct(TwigEngine $templating)
    {
        $this->templating = $templating;
    }

    public function searchFormat($datas, $searchClass)
    {

        $return = [];

        $datas['pagination']['nomRoute'] = 'tools_search';
        $datas['pagination']['search'] = true;
        $return['paginationView'] = $this->templating->render('ToolsBundle::pagination.html.twig', [
            'response' => [
                'pagination' => $datas['pagination']
            ]
        ]);

        switch ($searchClass){
            case 'publication':
                $return['datasView'] = $this->templating->render('PublicationBundle:publication/index-partial:publication-list.html.twig', [
                    'response' => [
                        'publications' => $datas['datas'],
                    ]
                ]);
                break;
            case 'user':
                $return['datasView'] = $this->templating->render('UserBundle:User/index-partial:user-list.html.twig', [
                    'response' => [
                        'users' => $datas['datas'],
                    ]
                ]);
                break;
            default:
                throw new BadRequestHttpException('Unknown searched class : '.$searchClass);
        }

        return $return;
    }
}