<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Document;
use App\Form\UserFormType;
use App\Entity\UserCharacter;
use App\Form\UserCharacterFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserController extends Controller{

    public function signin()
    {
        return $this->render('signin.html.twig');
    }


    public function userForm( Request $request, EncoderFactoryInterface $factory){
        $user = new User();
        $form = $this->createForm(
            UserFormType::class,
            $user,
            ['standalone'=> true]
        );

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //Create form with encoded password
            $encoder= $factory->getEncoder(User::class);
            $encodedPassword = $encoder->encodePassword(
                $user->getPassword(),
                $user->getUsername()
            );

            $user->setPassword($encodedPassword);

            $manager= $this->getDoctrine()->getManager();

            $file= $user->getPicture();

            if($file) {        
                $filename= uniqid().'.'.$file->guessExtension();

                $document = new Document();
                $document->setPath($this->getParameter('upload_dir'))
                ->setMimeType($file->getMimeType())
                ->setName($file->getFilename());

                $file->move($this->getParameter('upload_dir'));
                $user->setPicture($document);
                $manager->persist($document);
            }else{
                $filename= 'default.jpg';

                $document = new Document();
                $document->setPath('public/assets/img')
                ->setName($file->getFilename());

                $user->setPicture($document);
                $manager->persist($document);
            }

            $user->addRole($manager->getRepository(Role::class)->findOneBy(['label' => 'ROLE_USER']));

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('signin.html.twig', 
        ['user_form'=>$form->createView()]);
    }
}//class test
