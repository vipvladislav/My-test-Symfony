<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @param $aaa
     * @return Response
     * @Route("/{aaa}/blog", name="blog_list")
     */
    public function index($aaa)
    {
        $result =  $this->render('lucky/number.html.twig', ['number' => $aaa]);
        $this->addFlash('success', $aaa);

        return $result;
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route(path="/add-article")
     */
    public function next(EntityManagerInterface $entityManager)
    {
        $article = new Article();
        $article
            ->setImage('my-image')
            ->setContent('my-content')
            ->setTitle('my-title')
        ;

        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('Done!');
    }

    /**
     * @Route(path="/articles/{id}")
     * *
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function getArticle(Article $article, EntityManagerInterface $entityManager)
    {
        $article
            ->setTitle('Updated title')
            ->setContent('Updated content')
        ;
        $entityManager->flush();

        return new Response($article->getTitle());
    }

    /**
     * @Route(path="/articles/delete/{id}")
     * *
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function deleteArticle(Article $article, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return new Response('Deleted!');
    }


    /**
     * @Route(path="/list")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function list(EntityManagerInterface $entityManager)
    {
        $articleReppo = $entityManager->getRepository(Article::class);
        $articles = $articleReppo->findAll();

//        dd($articles);

        return new Response('list');
    }
}