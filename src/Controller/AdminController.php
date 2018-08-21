<?php

    namespace App\Controller;

    use App\Entity\Game;
    use App\Entity\User;
    use App\Entity\Post;
    use App\Entity\Category;
    use App\Entity\Document;
    use App\Form\GameFormType;
    use App\Entity\UserCharacter;
    use App\Form\CategoryFormType;
    use App\Form\DeleteUserFormType;
    use App\Form\UpdateUserFormType;
    use App\Form\DeleteCharacterFormType;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\File\File;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


    class AdminController extends Controller
    {

        /*
        ** USER LIST
        */
        public function userList()
        {
            // display the user list
            $manager = $this->getDoctrine()->getManager();

            $user = new User();

            return $this->render('Admin/User/list.html.twig', 
            [
                'users' => $manager->getRepository(User::class)->findBy([], ['username' => 'ASC'])
            ]);
        }

        public function userDetails(User $user, Request $request)
        {
            // get the user details by an get user=ID
            $updateForm = $this->createForm(UpdateUserFormType::class, $user, ['standalone' => true]);
            $updateForm->handleRequest($request);
            
            if ($updateForm->isSubmitted() && $updateForm->isValid())
        
            {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('admin_home', ['user' => $user->getId()]);
            }

            return $this->render('Admin/User/details.html.twig',
            [
                'user' => $user,
                'updateForm' => $updateForm->createView()
            ]);
        }

        public function userDelete(User $deleteUser, Request $request)
        {
            // get the user ID for deleting him
            $deleteForm = $this->createForm(DeleteUserFormType::class, $deleteUser, ['standalone' => true]);
            $deleteForm->handleRequest($request);

            // if form is submitted and valid
            if ($deleteForm->isSubmitted() && $deleteForm->isValid())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($deleteUser); // delete the user
                $manager->flush();

                return $this->redirectToRoute('admin_home', ['user' => $deleteUser->getId()]);
            }

            return $this->render('Admin/User/delete.html.twig',
            [
                'deleteUser' => $deleteUser,
                'deleteForm' => $deleteForm->createView()
            ]);
        }
        /*
        ** USER LIST END
        */

        /*
        **  REPORTED CHARACTER
        */
        public function characterList(Request $request)
        {
            // display character report list
            $manager = $this->getDoctrine()->getManager();

            $reportedCharacter = new UserCharacter();

            // reported character
            $char = $request->query->get('reportId');

            // if char is not empty
            if ($char)
            {
                $char = $manager->getRepository(UserCharacter::class)->find($char);

                // change reportet character to false, so it is not reported anymore
                $char->setReport(0);
                $manager->flush();

                return $this->redirectToRoute('admin_report_character');
            }

            return $this->render('Admin/Report/character.html.twig',
            [
                'reportedCharacters' => $manager->getRepository(UserCharacter::class)->findAll()
            ]);
        }
        
        public function characterDelete(UserCharacter $deleteChar, Request $request)
        {
            // CURRENTLY NOT WORKING, NEED TO BE FIXED
            $manager = $this->getDoctrine()->getManager();

            $deleteCharForm = $this->createForm(DeleteCharacterFormType::class, $deleteChar, ['standalone' => true]);
            $deleteCharForm->handleRequest($request);

            $deleteChar = $manager->getRepository(UserCharacter::class)->find($deleteChar);

            // if form is submitted and valid
            if ($deleteCharForm->isSubmitted() && $deleteCharForm->isValid())
            {
                $manager->remove($deleteChar); // delete character
                $manager->flush();

                return $this->redirectToRoute('admin_report_character');
            }

            return $this->render('Admin/Report/character_delete.html.twig',
            [
                'deleteChar' => $deleteChar,
                'deleteCharForm' => $deleteCharForm->createView()
            ]);

        }
        /*
        ** REPORTED CHARACTER END
        */
        
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
            $picture = $edit->getPicture();
            if ($picture) {
                $file = new File(
                    $picture->getPath() . '/' . $picture->getName()
                );
                $edit->setPicture($file);
            }

            $formEdit = $this->createForm(GameFormType::class, $edit, ['standalone' => true]);
            $formEdit -> handleRequest($request);

            if($formEdit->isSubmitted() && $formEdit->isValid())    {
                
                $file = $edit->getPicture();
                $filename = uniqid().'.'.$file->guessExtension();
                $manager = $this->getDoctrine()->getManager();
                if($file){

                    $document = new Document();
                    $document->setPath($this->getParameter('upload_dir'))
                        ->setMimeType($file->getMimeType())
                        ->setName($file->getFilename());

                    $file->move($this->getParameter('upload_dir'));

                    $edit->setPicture($document);

                    $manager->persist($document);
                
                }
                $manager->flush();

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

        public function deletePosts($deletePost)
        {
            $post = $this->getDoctrine()->getManager();
            $deletePost = $post->getRepository(Post::class)->find($deletePost);

            if(!$deletePost)
            {
                throw $this->createNotFoundedException(
                    'No Product found for Id' .$deletePost
                );
            }

            $post->remove($deletePost);
            $post->flush();

            return $this->redirectToRoute('admin_post_list');
        }
    
        public function categoryForm(Request $request)
        {
            $manager = $this->getDoctrine()->getManager();
            $category = new Category();

            $form = $this->createForm(
                CategoryFormType::class,
                $category,
                ['standalone'=>true]
            );
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                
                $manager->persist($category);
                $manager->flush();

                return $this->redirectToRoute('admin_category_list');
            }

            return $this->render(
                'Admin/Category/category.html.twig',
                [
                    'categoryForm'=>$form->createView(),
                    'categoryLists'=>$manager->getRepository(Category::class)->findAll()
                ]
            );
        }

        public function categoryDelete($categoryDel)
        {
            $category = $this->getDoctrine()->getManager();
            $categoryDel = $category->getRepository(Category::class)->find($categoryDel);
            if(!$categoryDel)
            {
                throw $this->createNotFoundedException(
                    'No Product found for Id' .$categoryDel
                );
            }
            $category->remove($categoryDel);
            $category->flush();

            return $this->redirectToRoute('admin_category_list');
        }

        public function displayPostList()
        {
            $manager = $this->getDoctrine()->getManager();

            $postList = $manager->getRepository(Post::class)->findAll();

            return $this->render(
                'Admin/posts/postlist.html.twig',
                ['postLists'=>$postList]
            
            );
        }
    
    }
?>