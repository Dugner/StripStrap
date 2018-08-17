<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use App\Form\GameFormType;
    use App\Entity\Game;
    use App\Entity\Document;
    use App\Entity\User;
    use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
    use App\Form\UpdateUserFormType;
    use Symfony\Component\HttpFoundation\File\File;


    class AdminController extends Controller
    {

    public function userList()
    {
        $manager = $this->getDoctrine()->getManager();

        $user = new User();

        return $this->render('Admin/User/list.html.twig', 
        [
            'users' => $manager->getRepository(User::class)->findBy([], ['username' => 'ASC'])
        ]);
    }

    public function userDetails(User $user, Request $request)
    {
        $updateForm = $this->createForm(UpdateUserFormType::class, $user, ['standalone' => true]);
        $updateForm->handleRequest($request);
        
        if ($updateForm->isSubmitted() && $updateForm->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_detail', ['user' => $user->getId()]);
        }

        return $this->render('Admin/User/details.html.twig',
        [
            'user' => $user,
            'updateForm' => $updateForm->createView()
        ]);
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

    public function editGame(Game $edit, Request $request)
    {
        $document = $this->getDoctrine()->getRepository(Document::class);
        $image = $document->find($edit);

        

        $formEdit = $this->createForm(GameFormType::class, $edit, ['standalone' => true]);
        $formEdit -> handleRequest($request);

        if($formEdit->isSubmitted() && $formEdit->isValid())    {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_game_list', ['edit' => $edit->getId()]);
        }
        
        return $this->render(
            'Admin/Game/game.html.twig',
            ['edit'=> $edit,
            'game_add' => $formEdit->createView()]
        );
        
    }

    public function deliteGame($delete)
    {
        $game = $this->getDoctrine()->getManager();
        $delete = $game->getRepository(Game::class)->find($delete);

        if (!$delete) {
             throw $this->createNotFoundException(
            'No product found for id '.$delete
        );
        }

        $game->remove($delete);
        $game->flush();

        return $this->redirectToRoute('admin_game_list');
    }
}
?>