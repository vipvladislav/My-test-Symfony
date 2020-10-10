<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("", name="home")
     */
    public function index()
    {
        return $this->render('lucky/index.html.twig');
    }

    /**
     * @param ArticleRepository $articleRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request)
    {
        $queryBuilder = $articleRepository->findArticlesQueryBuilder();
        $articles = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            9//*limit per page*/
        );


        return $this->render('lucky/blog.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_single")
     * @param Article $article
     * @return Response
     */
    public function blogSingle(Article $article)
    {
        return $this->render('lucky/blog_single.html.twig', [
            'article' => $article
        ]);

    }


    /**
     * @Route("/team", name="team")
     * @return Response
     */
    public function team()
    {
        return $this->render(/** @lang text */ 'lucky/team.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact()
    {
        return $this->render(/** @lang text */ 'lucky/contact.html.twig');
    }





    /**
     * @Route(path="/add-article", name="add-article")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function next(EntityManagerInterface $entityManager, Request $request)
    {
        $category = new Category();
        $category->setTitle('kykykyky');

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($article);
                $entityManager->flush();

                $this->addFlash('success', 'Done!');
                return $this->redirect('add-article');
            }

                return $this->render('lucky/article_form.html.twig', [
                'articleForm' => $form->createView(),
        ]);
     }

    /**
     * @Route(path="/articles/{id}", name="edit-article")
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function editArticle(Article $article, EntityManagerInterface $entityManager, Request $request)
    {
        $form = $this->createForm(
            ArticleType::class,
            $article,
            ['method' => $request->getMethod()]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Done!');
            return $this->redirectToRoute('edit-article', ['id'=> $article->getId()]);
        }

        return $this->render('lucky/article_form.html.twig', [
            'articleForm' => $form->createView(),
        ]);

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
        $articleRepository = $entityManager->getRepository(Article::class);
        $articles = $articleRepository->findAll();

        dd($articleRepository->findByCategoryId(4));

        return new Response('list');
    }
}