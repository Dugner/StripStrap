<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use App\Form\UserFormType;
use App\Entity\User;
use App\Entity\Document;



class UserController extends Controller{

    public function signin()
    {
        return $this->render('signin.html.twig');
    }


    public function userForm( Request $request, EncoderFactoryInterface $factory){

    //Create form with encoded password

        $user = new User;
        $form = $this->createForm(
            UserFormType::class,
            $user,
            ['standalone'=> true]
        );

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $encoder= $factory->getEncoder(User::class);
            $encodedPassword = $encoder->encodePassword(
                $user->getPassword(),
                $user->getUsername()
            );

            $user->setPassword($encodedPassword);


            $manager= $this->getDoctrine()->getManager();
            $file= $user->getPicture();
            $filename= uniqid().'.'.$file->guessExtension();
            if($file){

                $document = new Document();
                $document->setPath($this->getParameter('upload_dir'))
                ->setMimeType($file->getMimeType())
                ->setName($file->getFilename());

                $file->move($this->getParameter('upload_dir'));
                $user->setPicture($document);
                $manager->persist($document);
            }

            $manager->persist($user);
            $manager->flush();
            
            return $this->redirectToRoute('homepage');
        }

        return $this->render('signin.html.twig', 
        ['user_form'=>$form->createView()]);
    }
}//class