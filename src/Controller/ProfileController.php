<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\UserCharacter;
use App\Form\DeleteUserFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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