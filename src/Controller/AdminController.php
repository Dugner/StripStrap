<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use App\Entity\User;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
    use App\Form\UpdateUserFormType;
    use App\Form\DeleteUserFormType;


    class AdminController extends Controller
    {

        // display the user list
        public function userList()
        {
            $manager = $this->getDoctrine()->getManager();

            $user = new User();

            return $this->render('Admin/User/list.html.twig', 
            [
                'users' => $manager->getRepository(User::class)->findBy([], ['username' => 'ASC'])
            ]);
        }

        // get the user details by an get user=ID
        public function userDetails(User $user, Request $request)
        {
            $updateForm = $this->createForm(UpdateUserFormType::class, $user, ['standalone' => true]);
            $updateForm->handleRequest($request);
            
            // if form is submitted and valid
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

        // get the user ID for deleting him
        public function userDelete(User $deleteUser, Request $request)
        {
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

    }

?>