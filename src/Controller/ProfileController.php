<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\UserCharacter;

class ProfileController extends Controller{
    public function userInfos(){        
        return $this->render(
            'Profile/profile.html.twig',
            [
                'userCharacters' => $this->getDoctrine()->getManager()->getRepository(UserCharacter::class)->findBy(['user' => $this->getUser()->getId()])
            ]
        );
    }
}