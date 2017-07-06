<?php

namespace ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Historical controller.
 *
 */
class ToolsController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"search"})
     * @Rest\Get("/search")
     */
    public function searchAction(Request $request)
    {
        $search      = $request->get('search');
        $page        = $request->get('page');
        $searchClass = $request->get('searchClass');
        $limit       = $request->get('limit');

        return $this->get('unamag.tools.service.search')->search($searchClass, $search, $page, $limit);
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/random")
     */
    public function randomUsersAction() {

        return $this->get('unamag.tools.service.generate')->seedBase(25, false);
//        return $this->get('unamag.tools.service.generate')->createRandomUsers(5000);
    }
}
