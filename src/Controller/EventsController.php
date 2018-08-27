<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Cache\Simple\FilesystemCache;

class EventsController extends Controller{

    public function eventsPage(){
        return $this->render('API/events.html.twig');
    }
    public function getGameEvents(Request $request){
        
        $url= '/api/events/?api_key=501115dce72ea28ea903e0150924102c489f0810&format=json&page=2';
        $cache = $this->get('app.cache');
        $eventResult = $cache->getItem(md5($url));
        
        if (!$eventResult->isHit()) {
            $client = new \GuzzleHttp\Client(['base_uri' => 'http://www.gamespot.com']);
            
            $response = $client->request('GET', $url);
    
            if ($response->getStatusCode() != 200) {
                return $this->json(json_decode($response->getBody()->getContents()), 500);
            }
            
            $eventResult->set(json_decode($response->getBody()->getContents())->results);
            $eventResult->expiresAfter(3600);
            $cache->save($eventResult);
        }

        return new JsonResponse($eventResult->get());
    }
}