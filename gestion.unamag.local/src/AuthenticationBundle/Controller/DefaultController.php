<?php

namespace AuthenticationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AuthenticationBundle:Default:index.html.twig');
    }
}
