<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use App\Entity\User;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
    use App\Form\UpdateUserFormType;


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

    }

?>