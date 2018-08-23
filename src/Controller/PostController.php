<?php
namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Game;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\PostFormType;
use App\Form\CommentFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function wallPosts(Request $request)
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

            return $this->redirectToRoute('wall_list');
        }

        $games= $manager->getRepository(Game::class)->findAll();

        $categories= $manager->getRepository(Category::class)->findAll();
        
        $pagination = $manager
            ->getRepository(Post::class)
            ->paginateWall(
                $request, 
                $this->get('knp_paginator'), 
                $this->getParameter('list_limit'), 
                $this->getUser()
            );

        return $this->render(
            'wall/wall.html.twig',
            [
                'pagination' => $pagination,
                'postForm' => $form->createView(),
                'games' => $games,
                'categories'=> $categories
            ]
        );
    }

    public function deleteOwnPost(Post $postID, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $post = $manager->getRepository(Post::class)->find($postID);

        $checkAnon = $this->get('security.token_storage')->getToken()->getUser();
        $checkOwner = $this->get('security.token_storage')->getToken()->getUser()->getId();

        if ($checkAnon != 'anon.' && $checkOwner == $post->getUser()->getId())
        {
            $manager->remove($postID);
            $manager->flush();
        }

        return $this->redirectToRoute('homepage');
    }
}