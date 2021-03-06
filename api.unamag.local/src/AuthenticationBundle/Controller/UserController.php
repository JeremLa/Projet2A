<?php

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Entity\ActivationLink;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Form\UserType;
use FOS\RestBundle\View\View;
use SubscriptionBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserController extends Controller
{

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/user/bymail")
     */
    public function getUserByMailAction(Request $request)
    {
        $user = $this->get('unamag.service.user')->findByMailOrFalse($request->get('mail'));
        return $user;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/user/{id}")
     */
    public function getUserAction($id)
    {
        $user = $this->get('unamag.service.user')->findOneOr404($id);

        return $user;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Post("/user/edit")
     */
    public function editUserAction(Request  $request)
    {
        /**
         * @var $userDb User
         * @var $serializer Serializer
         */
        $serializer = $this->get('unamag.service.user')->getSerializer();
        $user = $serializer->deserialize($request->get('serializeObject'),User::class, 'json');

        $userDb = $this->get('unamag.service.user')->findOneOr404($user->getId());
        $userDb = $serializer->deserialize($request->get('serializeObject'),User::class, 'json',  array('object_to_populate' => $userDb));

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $user;
    }



    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users")
     */
    public function getUsersAction(Request $request)
    {
        
        $limit = $request->get('limit');
        $page = $request->get('page');

        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('AuthenticationBundle:User')->search($page, $limit);

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($publications) / $limit),
            'nomRoute' => 'user_homepage',
            'paramsRoute' => array()
        );

        return array(
            'users' => $publications,
            'pagination' => $pagination
        );
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Post("/users/new")
     */
    public function createUserAction(Request $request)
    {
        /** @var  $user User */
        $user = new User();
        $form = $this->createForm(UserType::class, $user);


        $form->submit($request->request->all());


        $user = $form->getData();

         $reponse = $this->get('unamag.service.user')->findByMailOrNull($user->getMail());


        if($reponse != null){
             return new JsonResponse('toto',400);
         }
        $user->setPassword($this->get('unamag.service.user')->encodePassword($user->getPassword()));

        $from = $request->get('from');
        $level = 2;
        $actif = 0;

        if($from === 'client'){
            $level = 2;
            $actif = 0;
        }else if( $from === 'gestion'){
            $level = 1;
            $actif = 1;
        }

        $user->setActif($actif);
        $user->setLevel($level);
        $user->setCanonicalFullname($this->get('unamag.tools.service.string')->canonicolize($user->getFirstname().' '.$user->getLastname()));

        $activation = $this->generateActivationLink($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->persist($activation);
        $em->flush();


        $message = new \Swift_Message('Confirmation d\'inscription');
        $message->setFrom(['contact@esimed.fr' => 'Unamag'])
            ->setTo($user->getMail())
//                ->setTo(['hermesalexis@gmail.com'])
        ->setBody(
            $this->renderView('@Authentication/Emails/registration.html.twig', array('name'=> $user->getFirstname().' '.$user->getLastname(),
                'hash' => $activation->getHash())),
            'text/html'
        );
        $this->get('mailer')->send($message);

        return $user;
    }

    public function generateActivationLink(User $user){
        $activation = new ActivationLink();
        $activation->setSalt($this->randomString());
        $activation->setUser($user);
        $activation->setHash($this->get('unamag.service.user')->encodePassword($activation->getSalt().$user->getMail()));
        $date = new \DateTime('now');
        $date->add(new \DateInterval('P7D'));
        $activation->setExpirationDate($date);
        return $activation;

    }

    private function randomString($length = 6) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Post("/users/actif")
     */
    public function changeActifStatutAction(Request $request){
        $id = $request->get('id');
        /**  @var $user User */
        $user = $this->get('unamag.service.user')->findOneOr404($id);
        if($user){
            $user->setActif(!$user->getActif());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $user;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users/search")
     */
    public function getSearchAction(Request $request){
        $limit = $request->get('limit') ? $request->get('limit') : 10;
        $page = $request->get('page') ? $request->get('page') : 15;
        $search = $request->get('search');

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AuthenticationBundle:User')->search($page, $limit, $this->get('unamag.tools.service.string')->canonicolize($search));

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($users) / $limit),
            'nomRoute' => 'user_search',
            'paramsRoute' => ['search' => $search]
        );

        return array(
            'users' => $users,
            'pagination' => $pagination
        );
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users/search/for-subscribe")
     */
    public function getUsersForSubscribeAction(Request $request){
        $publicationId = $request->get('publication');
        $search = $request->get('search');

        $users = $this->get('unamag.service.user')->getUserForSuscribe($publicationId, $this->get('unamag.tools.service.string')->canonicolize($search));

        return $users;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users/alertMail")
     */
    public function sendAlertMailAction(){

        $now = new \DateTime('now');
        $em = $this->getDoctrine()->getManager();
        $numberMail = 0;
        $result['number_of_mail'] = $numberMail;
        $users = $em->getRepository('AuthenticationBundle:User')->findAllActive();
        if($users == null){
            return 'Aucun utilisateurs dans la base';
        }else {
            /** @var  $user User */
            foreach ($users as $user) {
                $arr = [];
                /** @var  $sub Subscription */
                foreach ($user->getSubscription() as $sub) {
                    $dateEnd = clone $sub->getDateEnd();
                    if (!$sub->isMailAlert()) {
                        if ($dateEnd > $now) {
                            if ($dateEnd->modify('-2 month') < $now) {
                                $arr[] = $sub;
                                $result[$user->getCanonicalFullname()][] = $sub->getPublication()->getCanonicalTitle();
                                $sub->setMailAlert(true);
                            }
                        }
                    }
                }
                if(count($arr) > 0) {
                    $message = new \Swift_Message('Vos abonnements expirent !');
                    $message->setFrom(['contact@esimed.fr' => 'Unamag'])
                        ->setTo($user->getMail())
//                ->setTo(['hermesalexis@gmail.com'])
                        ->setBody(
                            $this->renderView('@Authentication/Emails/alertMail.html.twig', array('name' => $user->getFirstname() . ' ' . $user->getLastname(),
                                'subscriptions' => $arr)),
                            'text/html'
                        );
                    $numberMail = $numberMail + ($this->get('mailer')->send($message));
                }

            }
            $result['number_of_mail'] = $numberMail;
            $em->flush();
            return $result;
        }

    }
}
