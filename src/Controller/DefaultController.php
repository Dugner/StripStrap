<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Document;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;




class DefaultController extends Controller
{


    public function homepage(Request $request)
    {
            //$id= $request->query->get('id');

            //if(!$id){
                //throw new NotFoundHttpException();
            //}

           // $User = [];
           // return new Response(
                //$this->twig->render(
                   // 'leftsidebar.html.twig',
                   // ['users'=>$User[$id]]

                //)
           // ); 
            //$manager = $this->getDoctrine()->getManager();
            //$users= $manager->getRepository(User::class)->findAll();
    
    
        return $this->render('Default/homepage.html.twig');
    }
    
    //Login function

    public function login(AuthenticationUtils $authUtils){

        $error = $authUtils->getLastAuthenticationError();

            // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('Default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

    }

    public function downloadDocument(Document $document){
        $fileName = sprintf('%s/%s',
        $document->getPath(), $document->getName());
        return new BinaryFileResponse($fileName);
    }

}