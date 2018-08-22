<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use App\Form\UserFormType;
use App\Entity\User;
use App\Entity\Document;
use App\Entity\Role;
use App\Entity\UserCharacter;
use App\Entity\Post;
use App\Entity\Friend;

class UserController extends Controller{

    public function signup()
    {
        return $this->render('signup.html.twig');
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

        return $this->render('signup.html.twig', 
        ['user_form'=>$form->createView()]);


    }

    public function profile(User $user) {
        $userCharacter = new UserCharacter();
        
        $UserCharacterForm = $this->createForm(
            UserCharacterFormType::class,
            $userCharacter,
            ['standalone' => true]
        );

        return $this->render(
            'profile.html.twig',
            ['UserCharacterForm' => $UserCharacterForm->createView()]
        );

    }

    public function userWalls($userwall, Request $request)
    {
        $userDisplay = $this->getDoctrine()->getManager();

        $userCard = $userDisplay->getRepository(User::class)->findBy(['id'=>$userwall]);

        $userPost = $userDisplay->getRepository(Post::class)->findBy(['user'=>$userCard]);



        return $this->render(
            '/userWall/userWall.html.twig',
            [
                'users'=>$userCard,
                'posts'=>$userPost
            ]
        );
    }

    public function addNinja(User $addninja)
    {

        $friend = new Friend();

        $userId = $this->get('security.token_storage')->getToken()->getUser();

        $manager = $this->getDoctrine()->getManager();

        $friend->setToUser($addninja->getId());

        $friend->setReport(0);

        $friend->setUser($userId);

        $manager->persist($friend);

        $manager->flush($friend);

        return $this->redirectToRoute('search');
        
    }


}//class test
