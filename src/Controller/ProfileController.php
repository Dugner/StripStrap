<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;




class ProfileController extends Controller{

    public function userInfos(){
        return $this->render(
            'Profile/profile.html.twig'
        );
    }


}