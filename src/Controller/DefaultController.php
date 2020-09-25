<?php


namespace App\Controller;


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
     * @Route("/{aaa}/blog", name="blog_list")
     */
       public function index($aaa)
    {
        $result =  $this->render('lucky/number.html.twig', ['number' => $aaa]);
        $this->addFlash('success', $aaa);

        return $result;
    }
}