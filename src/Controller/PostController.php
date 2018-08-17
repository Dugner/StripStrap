<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;
use App\Form\PostFormType;
use Symfony\Component\Validator\Constraints\DateTime;

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
            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('wall_list');
        }

        $posts = $manager->getRepository(Post::class)
            ->findBy(
                ['user' => $this->getUser()],
                ['datetime' => 'DESC']
            );

        // $posts = $manager->getRepository(Post::class)->findAll();

        return $this->render(
            'wall/wall.html.twig',
            [
                'posts' => $posts,
                'postForm' => $form->createView(),
            ]
        );
    }
}