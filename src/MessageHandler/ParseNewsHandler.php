<?php 
namespace App\MessageHandler;

use App\Message\ParseNewsMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\NewsFeed;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class ParseNewsHandler implements MessageHandlerInterface{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

    }

    public function __invoke(ParseNewsMessage $parsenews){

        $this->logger->debug('Processing message', ['message' => $parsenews->getNewsData()]);
        // $entityManager = $this->doctrine->getManager();

       

        // // tell Doctrine you want to (eventually) save the Product (no queries yet)
        // $entityManager->persist($parsenews);

        // // actually executes the queries (i.e. the INSERT query)
        // $entityManager->flush();
    }
}

?>