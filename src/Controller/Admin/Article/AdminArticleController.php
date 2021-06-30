<?php

namespace App\Controller\Admin\Article;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminArticleController extends AbstractController
{

    private $articleRepository;
    private $em;
    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $em)
    {
        $this->articleRepository = $articleRepository;
        $this->em = $em;
    }


    /**
     * @Route("/blog", name="blog_index")
     */
    public function blog()
    {
        $articles = $this->articleRepository->findAll();
        return $this->render('home/blog.html.twig', [
            "articles" => $articles,
            "title" => "Notre blog"
        ]);
    }
    /**
     * @Route("/admin/article", name="admin_article_index")
     */
    public function index()
    {
        $articles = $this->articleRepository->findAll();
        return $this->render('admin/article/index.html.twig', [
            "articles" => $articles
        ]);
    }
    /**
     * @Route("/admin/article/create", name="admin_article_create")
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($article);
            $this->addFlash("success", "article ajouté avec succès");
            $this->em->flush();
            return $this->redirectToRoute("admin_article_index");
        }

        return $this->render("admin/article/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
