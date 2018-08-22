<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Game;


class GameController extends Controller{

    public function games(){
        $manager = $this->getDoctrine()->getManager();
        $games= $manager->getRepository(Game::class)->findAll();

        return $this->render(
            'wall/wall.html.twig',
            ['games'=> $games]
        );
    }

}