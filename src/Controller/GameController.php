<?php 

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


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
    public function getGames(Request $request){

        $client = new \GuzzleHttp\Client(['base_uri' => 'http://www.gamespot.com']);
        
        $url= '/api/games/?api_key=501115dce72ea28ea903e0150924102c489f0810&format=json&page=1200';
        $response = $client->request('GET', $url);


        if ($response->getStatusCode() != 200) {
            return $this->json(json_decode($response->getBody()->getContents()), 500);
        }

        return new JsonResponse(json_decode($response->getBody()->getContents())->results);
    }
}