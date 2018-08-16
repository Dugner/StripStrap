<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use App\Form\GameFormType;
    use App\Entity\Game;
    use App\Entity\Document;


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
                $file = $game->getPicture();
                $filename = uniqid().'.'.$file->guessExtension();
                
                if($file){

                    $document = new Document();
                    $document->setPath($this->getParameter('upload_dir'))
                        ->setMimeType($file->getMimeType())
                        ->setName($file->getFilename());

                    $file->move($this->getParameter('upload_dir'));

                    $game->setPicture($document);

                    $manager->persist($document);
                }
                $manager->persist($game);
                $manager->flush();

                return $this->redirectToRoute('admin_game');

            }
            return $this->render(
                'Admin/Game/game.html.twig',
                [
                    'game_add'=>$form->createView()]
                );
        }

        public function gameList()
        {
            $manager = $this->getDoctrine()->getManager();

            $gamelist = new Game();
            
            return $this->render(
                'Admin/Game/gamelist.html.twig',
                ['gamelist' => $manager->getRepository(Game::class)->findAll()]
            );
        }
        
        public function editGame(Game $game, Request $request)
        {
            $form = $this->createForm(
                GameFormType::class, 
                $game,
                ['standalone' => true]
                );
            
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute(
                    'admin_game', 
                    ['edit' => $game->getId()]);
            }

            return $this->render(
                'Admin/Game/game.html.twig',
                ['edit' => $game,
                'game_add'=>$form->createView()]
            );
        }

        
    }

?>