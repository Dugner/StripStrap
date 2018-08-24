<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\UserCharacter;
use App\Form\UserCharacterFormType;
use App\Entity\Document;

class UserCharacterController extends AbstractController
{
    /*public function listCharacters(Request $request) {
        $userCharacters = $this->getDoctrine()->getManager()->getRepository(UserCharacter::class)->findBy(['user' => $this->getUser()->getId()]);
            
        return $this->render(
            'Profile/profile.html.twig',
            [
                'userCharacters' => $userCharacters,
            ]
        );
    }*/

    public function addCharacter(Request $request) {
        $manager = $this->getDoctrine()->getManager();

        $userCharacter = new UserCharacter();
        $characterForm = $this->createForm(
            UserCharacterFormType::class,
            $userCharacter,
            ['standalone'=> true]
        );

        $characterForm->handleRequest($request);

        if($characterForm->isSubmitted() && $characterForm->isValid()) {
            $file = $userCharacter->getPicture();

            if($file) {        
                $filename = uniqid().'.'.$file->guessExtension();

                $picture = new Document();
                $picture->setPath($this->getParameter('upload_dir'))
                ->setMimeType($file->getMimeType())
                ->setName($file->getFilename());

                $file->move($this->getParameter('upload_dir'));
                $userCharacter->setPicture($picture);
                $manager->persist($picture);
            }

            $userCharacter->setUser($this->getUser());
            $userCharacter->setReport(false);

            $manager->persist($userCharacter);
            $manager->flush();

            return $this->redirectToRoute('user_info');
        }

        return $this->render(
            'Profile/characterForm.html.twig',
            [
                'titleForm' => 'Create a new character',
                'characterForm' => $characterForm->createView()
            ]
        );
    }

    public function deleteCharacter($character_id) {
        $manager = $this->getDoctrine()->getManager();
        $userCharacter = $manager->getRepository(UserCharacter::class)->find($character_id);

        if(!empty($userCharacter)) {
            $manager->remove($userCharacter);
            $manager->flush();
        }

        return $this->redirectToRoute('user_info');
    }

    public function editCharacter($character_id, Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $userCharacter = $manager->getRepository(UserCharacter::class)->find($character_id);

        $oldPicture = $userCharacter->getPicture();
        if(!empty($oldPicture)) {
            $file = new File($oldPicture->getPath() . '/' . $oldPicture->getName());
            $userCharacter->setPicture($file);
        }
            
        $characterForm = $this->createForm(
            UserCharacterFormType::class,
            $userCharacter,
            ['standalone'=> true]
        );   

        $characterForm->handleRequest($request);

        if($characterForm->isSubmitted() && $characterForm->isValid()) {
            $file = $userCharacter->getPicture();

            if($file){
                $filename = uniqid().'.'.$file->guessExtension();

                $picture = new Document();
                $picture->setPath($this->getParameter('upload_dir'))
                    ->setMimeType($file->getMimeType())
                    ->setName($file->getFilename());
                
                $file->move($this->getParameter('upload_dir'));
                $userCharacter->setPicture($picture);
                $manager->persist($picture);   
            } else {
                $userCharacter->setPicture($oldPicture);
            }

            $manager->flush();

            return $this->redirectToRoute('user_info');
        }

        return $this->render(
            'Profile/characterForm.html.twig',
            [
                'titleForm' => 'Edit a character',
                'characterForm' => $characterForm->createView()
            ]
        );
    }
    
    public function reportCharacter($character_id) {
        $manager = $this->getDoctrine()->getManager();
        $userCharacter = $manager->getRepository(UserCharacter::class)->find($character_id);

        if(!empty($userCharacter)) {
            $userCharacter->setReport(true);
            $manager->flush();
        }

        return $this->redirectToRoute('user_info');
    }
}
