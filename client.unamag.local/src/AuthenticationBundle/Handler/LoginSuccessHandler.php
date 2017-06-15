<?php
namespace AuthenticationBundle\Handler;


use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router   = $router;
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
            return new RedirectResponse($this->router->generate('authentication_prout'));
    }
}
?>