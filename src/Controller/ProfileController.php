<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\DeleteUserFormType;
use App\Entity\User;




class ProfileController extends Controller{

    public function userInfos(){
        return $this->render(
            'Profile/profile.html.twig'
        );
    }

}