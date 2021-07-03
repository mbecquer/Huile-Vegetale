<?php

namespace App\Controller\Admin\Article;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
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
            $this->addFlash("success", "Article ajouté avec succès");
            $this->em->flush();
            return $this->redirectToRoute("admin_article_index");
        }

        return $this->render("admin/article/create.html.twig", [
            "form" => $form->createView(),

        ]);
    }

    /**
     * @Route("/admin/article/edit/{id}", name="admin_article_edit")
     */
    public function edit(Article $article, Request $request)
    {

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash("success", "Article modifié avec succès");
            $this->em->flush();
            return $this->redirectToRoute("admin_article_index");
        }

        return $this->render('admin/article/edit.html.twig', [
            "form" => $form->createView(),
            'article' => $article
        ]);
    }
    /**
     * @Route("/admin/article/delete/{id}", name="admin_article_delete", methods="DELETE")
     */
    public function delete(Article $article, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->get('_token'))) {
            $this->em->remove($article);
            $this->em->flush();
            $this->addFlash("success", "Article supprimé avec succès");
            return $this->redirectToRoute('admin_article_index');
        };
    }
    /**
     * @Route("/blog/{id}",name="blog_read")
     */
    public function read(int $id, Request $request, EntityManagerInterface $em, CommentRepository $commentRepo)
    {
        $article = $this->articleRepository->find($id);
        $commentaires = $commentRepo->findBy([
            'article' => $article
        ]);
        //partie commentaires
        //on crée le commentaire vierge
        $comment = new Comment();
        //on génère le formulaire
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        //traitement formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime());
            $comment->setArticle($article);
            //on recupere le contenu du champ parent
            $parentid = $form->get('parent')->getData();
            //on va chercher le commentaire correspondant 
            if ($parentid != null) {
                $parent = $em->getRepository(Comment::class)->find($parentid);
            }

            //on définit le parent
            $comment->setParent($parent ?? null);

            $em->persist($comment);
            $em->flush();

            $this->addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('blog_read', ['id' => $article->getId()]);
        }

        return $this->render('blog/read.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'commentaires' => $commentaires,
        ]);
    }
}
