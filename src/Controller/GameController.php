<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Game;
use App\Entity\Category;


class GameController extends Controller{

    public function gamesList(){
        $manager = $this->getDoctrine()->getManager();
        $gamesList= $manager->getRepository(Game::class)->findAll();
        $categories= $manager->getRepository(Category::class)->findAll();

        return $this->render(
            'Games/games.html.twig',
            ['gamesList'=> $gamesList,
            'categories'=> $categories]
        );
    }

}