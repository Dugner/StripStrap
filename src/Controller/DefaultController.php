<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Character;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function homepage() {
        return $this->render('default/homepage.html.twig');
    }
    
    //Login function

    public function login(AuthenticationUtils $authUtils) {
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}