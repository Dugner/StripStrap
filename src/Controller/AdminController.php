<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;


    class AdminController extends Controller
    {

        public function home()
        {
            return $this->render('Admin/home.html.twig');
        }

    }

?>