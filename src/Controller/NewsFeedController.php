<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use App\Entity\NewsFeed;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Annotation as Security;


class NewsFeedController extends AbstractController {

    public function index(ManagerRegistry $doctrine):Response
    {
        $repository = $doctrine->getRepository(NewsFeed::class);
        $news = $repository->findAll();

        if (!$news) {
            throw $this->createNotFoundException(
                'No News Found'
            );
        }

        // return new Response(print_r($news));

     
     return $this->render('news_feed.html.twig', ['news' => $news]);
    }

    public function deleteArticle(int $id, ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(NewsFeed::class);
        $entityManager = $doctrine->getManager(); 
        $news = $repository->find($id);

        if (!$news) {
            throw $this->createNotFoundException(
                'No news found for id '.$id
            );
        }

        $entityManager->remove($news);
        $deleted = $entityManager->flush();

     return $this->redirectToRoute('news');
    }
}
?>