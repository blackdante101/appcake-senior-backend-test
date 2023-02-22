<?php
namespace App\Message;
use App\Service\ParseNews;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParseNewsMessage {
    public $newsDataArray;
    public $download_news_feed;

    public function __construct(HttpClientInterface $client, ManagerRegistry $doctrine, MessageBusInterface $bus){
        // $this->newsDataArray = $newsData;
        // $this->newsService->getNews();
        $this->download_news_feed =  new ParseNews($client, $doctrine, $bus);
        $this->download_news_feed->getNews();
    }

    public function getNewsData(){
        return true;
    }
}
?>