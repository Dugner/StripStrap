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
    public function commentPosts(Request $request)
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
            $comment->setUser($this-getUser());
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('wall_comment');
        }

        return $this->render(
            'wall/wall.html.twig',
            [
                'comments' => $comments,
                'commentForm' => $form->createView()
            ]
        );
    }
}