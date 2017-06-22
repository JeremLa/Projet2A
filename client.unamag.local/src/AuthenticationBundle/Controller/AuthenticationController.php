<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 14/06/2017
 * Time: 21:37
 */

namespace AuthenticationBundle\Controller;


use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Form\LoginType;
use AuthenticationBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\Provider\SimpleAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\User\InMemoryUserProvider;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class AuthenticationController extends Controller
{
    public function indexAction()
    {
        return $this->render('AuthenticationBundle:user:index.html.twig');
    }


    public function loginAction(Request $request){

        $user = new User();

        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $url = $this->getParameter('api')['user']['login'];
            $response = APIRequest::post($url, [], http_build_query($request->get('login')));

            if($response->code != 200){

                $error = $this->get('translator')->trans('auth.error');
                $this->get('session')->getFlashBag()->add('errors', $error);

                return $this->render('AuthenticationBundle:user:login.html.twig', array(
                    'form' => $form->createView(),
                ));

            }
            /** @var  $user User*/
            $user =  $this->get('unamag.service.user')->cast($user,$response->body);

            $unauthenticatedToken = new UsernamePasswordToken(
                $user->getMail(),
                $user->getPassword(),
                'main',
                $user->getRoles()
            );
            $this->get('security.token_storage')->setToken($unauthenticatedToken);
            $request->getSession()->set('_security_main', serialize($unauthenticatedToken));
            $event = new InteractiveLoginEvent($request, $unauthenticatedToken);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            $this->connectUser($user);
            return $this->redirectToRoute('publication_index');
        }

        return $this->render('AuthenticationBundle:user:login.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function createAccountAction(Request $request){
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $this->getParameter('api')['user']['create'];
            $response = APIRequest::post($url, [], http_build_query($request->get('user')));
            $user =  $this->get('unamag.service.user')->cast($user,$response->body);
            $this->connectUser($user);

            return $this->redirectToRoute('user_homepage');
        }

        return $this->render('AuthenticationBundle:user:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function logoutAction()
    {
        $this->get('session')->clear();
        $this->get('security.token_storage')->setToken(null);
        return $this->redirectToRoute('user_homepage');
    }

    public function connectUser($user){
        $this->get('session')->set('User', $user);
    }

}