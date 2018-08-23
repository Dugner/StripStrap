<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Friend;
use App\DTO\UserSearchBar;


class SearchController extends Controller
{
    public function userSearchCont(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $myId = $this->getUser()->getId();
        $dto = new UserSearchBar();

        $searchForm = $this->createForm(SearchFormType::class, $dto, ['standalone' => true]);
        
        $searchForm -> handleRequest($request);

        $user = $manager->getRepository(User::class)->findByUserSearchBar($dto);

        $friendId = $manager->getRepository(Friend::class)->findAll();


        return $this->render(
            'search/search.html.twig',
            [
                'friendId'=>$friendId,
                'myId'=>$myId,
                'users'=>$user,
                'userSearch' => $searchForm->createView()
            ]

        );
    }
}