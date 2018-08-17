<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Post;
use App\Form\PostFormType;
use Symfony\Component\HttpFoundation\Request;


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
            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('index_list');
        }

        // $posts = $manager->getRepository(Post::class)
        //     ->findBy(
        //         ['id' => 'DESC']
        //     );

        $posts = $manager->getRepository(Post::class)->findLimit($this->getParameter('list_limit'));
        shuffle($posts);

        return $this->render(
            'default/homepage.html.twig',
            [
                'posts' => $posts,
                'homePostForm' => $form->createView(),
            ]
        );
    }
    
    //Login function

    public function login(AuthenticationUtils $authUtils){

        $error = $authUtils->getLastAuthenticationError();

            // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

    }
}