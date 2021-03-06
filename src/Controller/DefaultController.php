<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Game;
use App\Entity\Document;
use App\Entity\Category;
use App\Form\PostFormType;
use App\Entity\UserCharacter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Comment;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function homepage(Request $request)
    {
        // Get the user ID who is logged in
        $userId = $this->get('security.token_storage')->getToken()->getUser();

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

        $games= $manager->getRepository(Game::class)->findAll();
        $categories= $manager->getRepository(Category::class)->findAll();

        $pagination = $manager->getRepository(Post::class)->paginate($request, $this->get('knp_paginator'), $this->getParameter('list_limit'));
        

        return $this->render(
            'Default/homepage.html.twig',
            [
                'pagination' => $pagination,
                'homePostForm' => $form->createView(),
                'games'=> $games,
                'userId' => $userId,
                'categories'=> $categories,
            ]
        );
    }
    


    public function commentHomePosts(Post $post, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $form = $this->createForm(
            CommentFormType::class,
            $comment,
            ['standalone' => true]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);
            // $comment->setUser($user);
            $comment->setUser($post->getUser());
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute("wall_comment", ['post' => $post->getId()]);
        }

        $comments = $manager
            ->getRepository(Comment::class)
            ->findBy(
                ['post' => $post->getId()],
                ['datetime' => 'DESC']
            );

        return $this->render(
            'Comment/comment.html.twig',
            [
                'post' => $post,
                'comments' => $comments,
                'commentForm' => $form->createView()
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
            $document->getPath(), 
            $document->getName()
        );
        return new BinaryFileResponse($fileName);
    }

    public function userCard(){
        $userCard= $this->userCard;
        return $this->render(
           'leftsidebar.html.twig'
        );
    }


    
    public function downloadDocumentAdmin(Document $document) {
        $fileName = sprintf('%s/%s', $document->getPath(), $document->getName());

        return new BinaryFileResponse($fileName);
    }
}