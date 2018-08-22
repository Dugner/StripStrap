<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostFormType;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Entity\Game;
use App\Entity\Category;

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

        $manager->remove($postID);
        $manager->flush();

        return $this->redirectToRoute('homepage');
    }
}