<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Document;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Entity\UserCharacter;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Post;
use App\Form\PostFormType;


class DefaultController extends Controller
{
    public function homepage(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $post = new Post();
        $form = $this->createForm(
            PostFormType::class,
            $post,
            ['standalone' => true]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($this->getUser());
            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('index_list');
        }

        $pagination = $manager->getRepository(Post::class)->paginate($request, $this->get('knp_paginator'), $this->getParameter('list_limit'));

        return $this->render(
            'default/homepage.html.twig',
            [
                'pagination' => $pagination,
                'homePostForm' => $form->createView(),
            ]
        );
    }


    //Login function
    public function login(AuthenticationUtils $authUtils) {
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('Default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    public function downloadDocument(Document $document){
        $fileName = sprintf('%s/%s',
        $document->getPath(), $document->getName());
        return new BinaryFileResponse($fileName);
    }

    public function userCard(){
        return $this->render(
           'leftsidebar.html.twig'
        );
    }


    
    public function downloadDocumentAdmin(Document $document) {
        $fileName = sprintf('%s/%s', $document->getPath(), $document->getName());

        return new BinaryFileResponse($fileName);
    }
}