<?php 
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use App\Entity\NewsFeed;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\ParseNewsMessage;

class ParseNews {
    private $client;
    private $logger;
    private $doctrine;
    private $bus;

    public function __construct(HttpClientInterface $client, ManagerRegistry $doctrine, MessageBusInterface $bus)
    {
        $this->client = $client;
        $this->doctrine = $doctrine;
        $this->bus = $bus;
    }

    public function getNews(): Response {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/everything?q=bitcoin&apiKey=26d740be9dfa45ef85df3394a57f055a'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        
        foreach($content['articles'] as $article){
            $entityManager = $this->doctrine->getManager();
            $feed = new NewsFeed();
            
            $dataExists = $this->doctrine->getRepository(NewsFeed::class)->findOneBy([
                'title' => $article['title'], // Replace with the actual property name and value to check
            ]);
            if($dataExists){
                $entityManager2 = $this->doctrine->getManager();
                $product = $this->doctrine->getRepository(NewsFeed::class)->find($dataExists->getId());
                $feed->setShortDescription($dataExists->getShortDescription().'<br> <b>Article was last updated '.date("Y-m-d H:i:s"));
                $entityManager2->flush();
            } else {
                $feed->setShortDescription($article['description']);
            }
           
            $feed->setTitle($article['title']);
          
            $feed->setPicture($article['urlToImage']);
            $feed->setDateAdded(date("Y-m-d H:i:s"));
            $feed->setLastModified(date("Y-m-d H:i:s"));

            $entityManager->persist($feed);
            $entityManager->flush();

            // $this->bus->dispatch(new ParseNewsMessage("einus"));
        }


        return new Response(true);
        // return $content;
    }
}



?>