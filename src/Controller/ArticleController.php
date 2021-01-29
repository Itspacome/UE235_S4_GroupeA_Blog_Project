<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/{page}", name="article_index", methods={"GET"}, requirements={"page": "\d+"})
     */
    public function index(ArticleRepository $articleRepository, $page = 1): Response /*par défaut la page est 1*/
    {
        /* sytème de pagination grâce à des limites pour gérer l'affichage suivant..., exemple :
        si je suis sur la page 1 → 1 * 4 = 4 - 4 = 0 donc je partirais de 0
        sur la page 2 → 2 * 4 = 8 - 4 = 4 donc je partirais de 4 */
        $limit = 4; 
        $start = $page * $limit - $limit;                       /*définit le départ d'affichage de chaque page*/
        $nbArticles = count($articleRepository->findAll());     /*contient le nombre total d'article*/
        $nbPages    = ceil($nbArticles / $limit);               /*nb total de pages*/

        return $this->render('article/index.html.twig', [
            /*findBy() au lieu de findAll() pour select seulement les éléments voulus*/
            'articles' => $articleRepository->findBy([], [], $limit, $start), /*1er [] vide permet de filtrer la recherche, 2eme [] vide permet d'ordonner éléments*/
            'nb_pages'    => $nbPages,
            'actual_page' => $page
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
