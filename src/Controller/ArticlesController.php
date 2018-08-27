<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class ArticlesController extends Controller{

    public function articlesPage(){
        return $this->render('API/articles.html.twig');
    }
    

    public function getGameArticles(Request $request){
        
        $url= '/api/articles/?api_key=501115dce72ea28ea903e0150924102c489f0810&format=json&page=1280&limit=' . $request->query->get('page', 100);
        $cache = $this->get('app.cache');
        $articleResult = $cache->getItem(md5($url));
        
        if (!$articleResult->isHit()) {
            $client = new \GuzzleHttp\Client(['base_uri' => 'http://www.gamespot.com']);
            
            $response = $client->request('GET', $url);
    
            if ($response->getStatusCode() != 200) {
                return $this->json(json_decode($response->getBody()->getContents()), 500);
            }
    
            $articleResult->set(json_decode($response->getBody()->getContents())->results);
            $articleResult->expiresAfter(3600);
            $cache->save($articleResult);
        }
        
        return new JsonResponse($articleResult->get());

    }

}