<?php 
// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ParseNews;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Message\ParseNewsMessage;

// the name of the command is what users type after "php bin/console"
// #[AsCommand(name: 'app:parse-news')]
class ParseNewsCommand extends Command
{
    protected static $defaultName = 'app:parse-news';
    private $newsService;
    private $bus;
    private $doctrine;
    private $client;
    // private $requestStack;

    public function __construct(ParseNews $parseNews, MessageBusInterface $bus,  HttpClientInterface $client, ManagerRegistry $doctrine){
        $this->newsService = $parseNews;
        $this->bus = $bus;
        $this->doctrine = $doctrine;
        $this->client = $client;

        parent::__construct();
    }
    // the command description shown when running "php bin/console list"
    protected static $defaultDescription = 'parse news from news resources';

    // ...
    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to parse and download news from api endpoint');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        if($this->bus->dispatch(new ParseNewsMessage($this->client, $this->doctrine, $this->bus))){
            $output->writeln('News Parsed Succesfully :)');
            return Command::SUCCESS;
        } else {
            $output->writeln('Error Parsing News');
            return Command::FAILURE;
        }
        

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}


?>