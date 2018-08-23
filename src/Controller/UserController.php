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
use App\Form\UpdateProfileUserFormType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Form\UpdatePasswordUserFormType;
use Symfony\Component\HttpFoundation\File\File;

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

            return $this->redirectToRoute('homepage');
        }

        return $this->render('signin.html.twig', 
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
}//class test
