<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Document;
use App\Form\UserFormType;
use App\Entity\UserCharacter;
use App\Form\UpdateProfileUserFormType;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\Post;
use App\Entity\Friend;
use App\Form\UserCharacterFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends Controller{

    public function signup()
    {
        return $this->render('signup.html.twig');
    }


    public function userForm( Request $request, EncoderFactoryInterface $factory, TokenStorageInterface $tokenStorage){
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
            }//else{
            //     $filename= 'default.jpg';

            //     $document = new Document();
            //     $document->setPath('public/assets/img')
            //     ->setName($filename);

            //     $user->setPicture($document);
            //     $manager->persist($document);
            // }

            $user->addRole($manager->getRepository(Role::class)->findOneBy(['label' => 'ROLE_USER']));

            $manager->persist($user);
            $manager->flush();

            $tokenStorage->setToken(new UsernamePasswordToken($user, null, 'main', $user->getRoles()));

            return $this->redirectToRoute('homepage');
        }

        return $this->render('signup.html.twig', 
        ['user_form'=>$form->createView()]);
    }
    
    public function updateProfileUser(User $currentUser, Request $request) {
        $manager = $this->getDoctrine()->getManager();
        
        $oldPicture = $currentUser->getPicture();
        if(!empty($oldPicture)) {
            $file = new File($oldPicture->getPath() . '/' . $oldPicture->getName());
            $currentUser->setPicture($file);
        }

        $userForm = $this->createForm(
            UpdateProfileUserFormType::class,
            $currentUser,
            ['standalone'=> true]
        );

        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) { 
            $file = $currentUser->getPicture();

            if($file){
                $filename = uniqid().'.'.$file->guessExtension();

                $picture = new Document();
                $picture->setPath($this->getParameter('upload_dir'))
                    ->setMimeType($file->getMimeType())
                    ->setName($file->getFilename());
                
                $file->move($this->getParameter('upload_dir'));
                $currentUser->setPicture($picture);
                $manager->persist($picture);   
            } else {
                $currentUser->setPicture($oldPicture);
            }

            $manager->flush();

            return $this->redirectToRoute('user_info');
        }
        
        return $this->render(
            'Profile/profileForm.html.twig', 
            [
                'titleForm' => 'Update a user',
                'profileForm' => $userForm->createView()
            ]
        );
    }

    public function updateProfilePassword(User $currentUser, Request $request, EncoderFactoryInterface $factory, TokenStorageInterface $tokenStorage) {
        $manager = $this->getDoctrine()->getManager();
        $currentPassword = $this->getUser()->getPassword();

        $passwordForm = $this->createForm(
            UpdatePasswordUserFormType::class,
            $currentUser,
            ['standalone'=> true]
        );

        $passwordForm->handleRequest($request);

        if($passwordForm->isSubmitted() && $passwordForm->isValid()) { 
            $encoder = $factory->getEncoder(User::class);
            $isValid = $encoder->isPasswordValid($currentPassword, $passwordForm['oldPassword']->getData(), $currentUser->getUsername() );

            if( $isValid && !empty($currentUser->getPassword()) ) {          
                $encodedPassword = $encoder->encodePassword( $currentUser->getPassword(), $currentUser->getUsername() );

                $currentUser->setPassword($encodedPassword);
                $manager->flush();

                $tokenStorage->setToken(null);

                return $this->redirectToRoute('login');
            }
        }

        return $this->render(
            'Profile/profileForm.html.twig', 
            [
                'titleForm' => 'Update a password',
                'profileForm' => $passwordForm->createView()
            ]
        );
    }

    public function deleteProfileUser(User $currentUser, TokenStorageInterface $tokenStorage) {
        $manager = $this->getDoctrine()->getManager();

        if(!empty($currentUser)) {
            $tokenStorage->setToken(null); // Logout the current session

            foreach($currentUser->getPosts() as $post)
                $manager->remove($post);
            $manager->remove($currentUser);
            $manager->flush();
        }

        return $this->redirectToRoute('homepage');
    }
    
    public function userWalls($userwall)
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

        $friend->setToUser($addninja);
        $friend->setReport(0);
        $friend->setUser($userId);

        $manager->persist($friend);
        $manager->flush($friend);

        return $this->redirectToRoute('search');   
    }  
}
