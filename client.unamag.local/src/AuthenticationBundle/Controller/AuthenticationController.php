<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 14/06/2017
 * Time: 21:37
 */

namespace AuthenticationBundle\Controller;


use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class AuthenticationController extends Controller
{
    public function indexAction()
    {
        $url = $this->getParameter('api')['user']['get_all'];
        $response = APIRequest::get($url, [], []);

        VarDumper::dump(new \DateTime('now'));
        die;
//        $data = [];
//        $data['firstName'] = 'Jérémy';
//        $data['lastName']  = 'Lahore';
//        $data['adress']    = 'rue de la bas';
//        $data['city']      = 'pasla';
//        $data['zipCode']   = '30200';
//        $data['mail']      = 'mail@mail.com';
//        $data['tel']       = '0000000000';
//        $data['birthDate'] = '03-10-1985';
//        $data['birthCity'] = 'pasla';
//        $data['password']  = '123';
//        $data['level']     = 0;

//        $response = Request::post('http://api.unamag.local/users/create', [], http_build_query($data));
//        VarDumper::dump($response);
//        die;
        return $this->render('AuthenticationBundle:index.html.twig');
    }


    public function loginAction(){

    }

    public function createAccountAction(Request $request){
        // just setup a fresh $task object (remove the dummy data)
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $this->getParameter('api')['user']['create'];
            $response = APIRequest::post($url, [], http_build_query($request->get('user')));

            VarDumper::dump($response);
            die;
        }

        return $this->render('AuthenticationBundle:user:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}