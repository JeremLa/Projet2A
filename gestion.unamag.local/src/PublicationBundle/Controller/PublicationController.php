<?php

namespace PublicationBundle\Controller;

use AuthenticationBundle\Entity\User;
use PublicationBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

/**
 * Publication controller.
 *
 */
class PublicationController extends Controller
{
    /**
     * Lists all publication entities.
     *
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page') ? $request->get('page') : 1;
        $url = $this->getParameter('api')[PubliConst::KEYPUBLICATION]['get_all'];
        $response = APIRequest::get($url, [], ['page' => $page, 'limit', 'limit' => 8]);
        return $this->render('PublicationBundle:publication:index.html.twig', array(
            'response' => $response->body,
        ));
    }

    /**
     * Creates a new publication entity.
     *
     */
    public function newAction(Request $request)
    {
        /**
         * @var $publication Publication
         */
        $publication = new Publication();
        $form = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var  $file UploadedFile */
            $file = $request->files->all()['publicationbundle_publication']['file'];

            if(!$file){
                $file_real_path = realpath($this->get('kernel')->getRootDir(). " /../web/assets\images\unknown.jpg");
            }else{
                $file_real_path = $file->getRealPath();
            }

            $file_binary = fread(fopen($file_real_path, "r"), filesize($file_real_path));
            $img_str = base64_encode($file_binary);

            $publication->setPicture($img_str);

            /** @var  $serializer Serializer*/
            $serializer = $this->get('unamag.service.user')->getSerializer();
            APIRequest::post($this->getParameter('api')[PubliConst::KEYPUBLICATION]['create'], ['Content-Type' => "application/json"], $serializer->serialize($publication, 'json'));

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('PublicationBundle:publication:new.html.twig', array(
            PubliConst::KEYPUBLICATION => $publication,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publication entity.
     *
     */
    public function showAction($id)
    {
        $url = $this->getParameter('api')[PubliConst::KEYPUBLICATION]['get'];

        APIRequest::jsonOpts(true);
        $publication = APIRequest::get($url, [], ['publicationId' => $id])->body;

        $now = new \DateTime('now');
        $countAge['-18'] = 0;
        $countAge['18-25'] = 0;
        $countAge['25-40'] = 0;
        $countAge['40-60'] = 0;
        $countAge['60+'] = 0;
        $dep = [];
        $depRes = [];
        foreach ($publication['subscription'] as $sub){
            // si l'abonnement n'est pas expiré
            if(new \DateTime($sub['dateEnd']) > $now){
                /** @var  $user User*/
                $user = $sub['user'];
                $age = $this->get('unamag.service.user')->calculAge($user['birthDate']);
//                VarDumper::dump($age);die;
                $department = substr($user['zipCode'],0,2);
                if(array_search($department, $dep) == false){
                    $dep[] = $department;
                    $depRes[$department] = 1;
                }else{
                    $depRes[$department]++;
                }

                if($age < 18){
                    $countAge['-18']++;
                }elseif ($age < 25){
                    $countAge['18-25']++;
                }elseif ($age < 40){
                    $countAge['25-40']++;
                }elseif ($age < 60 ){
                    $countAge['40-60']++;
                }else{
                    $countAge['60+']++;
                }

            }
        }
        $strCountAge = "";
        $comma = 1;
        foreach ($countAge as $count){
            if($comma != count($countAge)){
                $strCountAge = $strCountAge . $count .',';
            }else{
                $strCountAge = $strCountAge . $count;
            }
            $comma++;
        }

//        $strDep = "";
//        $comma = 1;
//        foreach ($depRes as $count){
//            if($comma != count($depRes)){
//                $strDep = $strDep . $count .',';
//            }else{
//                $strDep = $strDep . $count;
//            }
//            $comma++;
//        }

        $strDepH = "";
        $comma = 1;
        foreach ($dep as $numDep){
            if($comma != count($dep)){
                $strDepH = $strDepH . 'department-'.$numDep .':'.$depRes[$numDep].',';
            }else{
                $strDepH = $strDepH . 'department-'.$numDep.':'.$depRes[$numDep];
            }
            $comma++;
        }
        return $this->render('PublicationBundle:publication:show.html.twig', array(
            'publication' => $publication,
            'ageData' => $strCountAge,
            'depHead' => $strDepH,
        ));
    }

    /**
     * Displays a form to edit an existing publication entity.
     *
     */
    public function editAction(Request $request, Publication $publication)
    {
        $publiMod = clone $publication;
        $editForm = $this->createForm('PublicationBundle\Form\PublicationType', $publiMod);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            /** @var  $file UploadedFile */
            $file = $request->files->all()['publicationbundle_publication']['file'];

            if($file){
                $file_real_path = $file->getRealPath();
                $file_binary = fread(fopen($file_real_path, "r"), filesize($file_real_path));
                $img_str = base64_encode($file_binary);

                $publiMod->setPicture($img_str);
            }

            $send = new Publication();
            $send->setId($publiMod->getId());
            $send->setTitle($publiMod->getTitle());
            $send->setCountByYear($publiMod->getCountByYear());
            $send->setAnnualCost($publiMod->getAnnualCost());
            $send->setDescription($publiMod->getDescription());
            $send->setPicture($publiMod->getPicture());


            $serializer = $this->get('unamag.service.user')->getSerializer();
            $url = $this->getParameter('api')[PubliConst::KEYPUBLICATION]['update'];

            $response = APIRequest::put($url, ['Content-Type' => "application/json"], $serializer->serialize($send, 'json'));
            return $this->redirectToRoute('publication_index');
        }

        return $this->render('PublicationBundle:publication:edit.html.twig', array(
            'publication' => $publiMod,
            'form' => $editForm->createView(),
        ));
    }

    public function searchAction(Request $request)
    {

        $page = $request->get('page') ? $request->get('page') : 1;
        $search = $request->get('search') ? $request->get('search') : '';

        $url = $this->getParameter('api')['publication']['search'];

        APIRequest::jsonOpts(true);

        $response = APIRequest::get($url, [], [
            'page' => $page,
            'search' => $search
        ])->body;

        $return = [];

        foreach ($response as $key => $value) {
            if ($key === 'users') {
                $return[$key]['view'] = $this->renderView('@User/User/index-partial/user-list.html.twig', [
                    'response' => ['users' => $value]
                ]);
            } elseif ($key === 'pagination') {
                $return[$key]['view'] = $this->renderView('@User/User/index-partial/pagination.html.twig', [
                    'response' => ['pagination' => $value]
                ]);
            }
        }

        return new JsonResponse($return);
    }


    public function deleteAction(Request $request){
        $url = $this->getParameter('api')['publication']['delete'];

        $response = APIRequest::delete($url, [], http_build_query(['publicationId' => $request->get('publicationId')]));
        if($response->code != 200){
            $error = $this->get('translator')->trans('publication.error.delete');
            $this->get('session')->getFlashBag()->add('errors', $error);

            return $this->redirectToRoute('publication_show', ['id' => $request->get('publicationId')]);
        }
        return $this->redirectToRoute('publication_list');
    }
}