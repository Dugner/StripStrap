<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\DTO\UserSearchBar;


class SearchController extends Controller
{
    public function userSearchCont(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $dto = new UserSearchBar();

        $searchForm = $this->createForm(SearchFormType::class, $dto, ['standalone' => true]);
        
        $searchForm -> handleRequest($request);

        $user = $manager->getRepository(User::class)->findByUserSearchBar($dto);
            
        
        


        return $this->render(
            'search/search.html.twig',
            [
                'users'=>$user,
                'userSearch' => $searchForm->createView()
            ]

        );
    }
}