<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class VideosController extends Controller{

    public function videosPage(){
        return $this->render('API/videos.html.twig');
    }

    public function getGameVideos(){
        
        $url= '/api/videos/?api_key=501115dce72ea28ea903e0150924102c489f0810&format=json&page=885';
        $cache = $this->get('app.cache');
        $videoResult = $cache->getItem(md5($url));
        
        if (!$videoResult->isHit()) {
            $client = new \GuzzleHttp\Client(['base_uri' => 'http://www.gamespot.com']);
            
            $response = $client->request('GET', $url);
    
            if ($response->getStatusCode() != 200) {
                return $this->json(json_decode($response->getBody()->getContents()), 500);
            }
    
            $videoResult->set(json_decode($response->getBody()->getContents())->results);
            $videoResult->expiresAfter(3600);
            $cache->save($videoResult);
        }
        
        return new JsonResponse($videoResult->get());
    }
}