<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use App\Form\GameFormType;
    use App\Entity\Game;
    use App\Entity\Document;
    use App\Entity\Category;


    class AdminController extends Controller
    {

        public function home()
        {
            return $this->render('Admin/home.html.twig');
        }

        public function gameForm(Request $request)
        {
            $game = new Game();

            $form = $this->createForm(
                GameFormType::class,
                $game,
                ['standalone' => true]
            );

            $form->handleRequest($request);

            
            
            if($form->isSubmitted() && $form->isValid()){

                $manager = $this->getDoctrine()->getManager();
                $file = $game->getPicure();
                $filename = uniqid().'.'.$file->guessExtension();
                
                if($file){

                    $document = new Document();
                    $document->setPath($this->getParameter('upload_dir'))
                        ->setMimeType($file->getMimeType())
                        ->setName($file->getFilename());

                    $file->move($this->getParameter('upload_dir'));

                    $user->setPicure($document);

                    $manager->persist($document);
                }
                $manager->persist($game);
                $manager->flush();

                return $this->redirectToRoute('Admin/game.html.twig');

            }
            return $this->render(
                'Admin/game.html.twig',
                ['game_add'=>$form->createView()]
                );
        }

    }

?>