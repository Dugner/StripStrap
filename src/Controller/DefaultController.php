<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Document;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class DefaultController extends Controller
{
    public function homepage()
    {
        return $this->render('default/homepage.html.twig');
    }


    //Login function

    public function login(AuthenticationUtils $authUtils){

        $error = $authUtils->getLastAuthenticationError();

            // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

    }
    
    public function downloadDocument(Document $document) {
        $fileName = sprintf('%s/%s', $document->getPath(), $document->getName());

        return new BinaryFileResponse($fileName);
    }
}