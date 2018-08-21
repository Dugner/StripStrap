<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;
use App\Form\CommentFormType;
use Symfony\Component\Validator\Constraints\DateTime;

class CommentController extends Controller
{
    public function commentPosts(Post $post, Request $request)
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
            $comment->setUser($this->getUser());
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute("wall_comment", ['post' => $post->getId()]);
        }

        $comments = $manager->getRepository(Comment::class)->findAll();

        return $this->render(
            'Comment/comment.html.twig',
            [
                'post' => $post,
                'comments' => $comments,
                'commentForm' => $form->createView()
            ]
        );
    }
}