<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Article;
use AppBundle\Repository\ArticleRepository;
use AppBundle\Form\ArticleType;
use AppBundle\File\FileUploader;
use Symfony\Component\HttpFoundation\File\File;

/**
* @Route("/article", name="article")
*/
class ArticleController extends Controller
{
    /**
     * @Route(
     *    "/",
     *    name="article_index")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render(
            'article/index.html.twig',
            ['articles' => $this->getDoctrine()->getRepository('AppBundle:Article')->findAll()]
        );
    }

    /**
    * @Route(
    *    "/{id}",
    *    name="article_show",
    *    requirements={"id" : "\d+"})
    */
    public function showAction(Article $article)
    {
        dump($article);
        return $this->render(
            'article/show.html.twig',
            ['article' => $article]
        );
    }

    /**
    * @Route(
    *    "/new",
    *    name="article_new")
    */
    public function newAction(Request $request)
    {
        $article = new Article();
        
        //Construction du formulaire auquel on passe l'article
        $form = $this->createForm(ArticleType::class, $article);

        // on configure le bouton de soumission de formulaire dans add.html.twig
        //car ça relève de l'affichage donc n'a rien à faire dans du php
        //pour pouvoir le modifier dans le cas d'une modification d'article
        // form->add('submit', SubmitType::class, array(
        //     'label' => 'Créer l\'article',
        //     'attr'  => array('class' => 'btn btn-default pull-right')
        // ));

        // $request contient un tableau : si l'élément errors n'est pas vide $form->isValid renverra false
        $form->handleRequest($request);

        // Gestion de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            // on upload l'image d'en-tête
            $this->get('file.uploader')->upload($article);

            $em = $this->getDoctrine()->getManager();

            // créé l'objet et prépare la requête d'insertion
            $em->persist($article);
            
            // exécute la requête
            $em->flush();

            $this->addFlash('success', "L'article a bien été créé et sauvegardé en base de donnée!");

            // Si le formulaire est soumis et valide on redirige sur la visualisation de l'article
            // Si redirection dans le même contrôleur utiliser plutot forward : comme redirect 
            // va utiliser une master request mais en gardant le contexte de la requête précédente
            return $this->redirect($this->generateUrl('article_show', ['id' => $article->getId()]));
        }
    
        // Si le formulaire n'est pas valide on affiche à nouveau le formulaire
        return $this->render('article/add.html.twig', array('form' => $form->createView()));
    }

    /**
    * @Route(
    *    "/update/{id}",
    *    name="article_update",
    *    requirements={"id" : "\d+"})
    */
    public function updateAction(Request $request, Article $article)
    {

        // Récuparation de l'image d'en tête actuelle (avant modification)
        $articleImgPath = $article->getHeaderImage();
        if ($articleImgPath != null) {
            $article->setHeaderImage(new File($this->getParameter('file_path').$articleImgPath));
        }
        dump($article);

        //Construction du formulaire auquel on passe l'article
        //ArticleType::class : rend le nom de la classe avec son namespace
        $form = $this->createForm(ArticleType::class, $article);

        //$request contient un tableau : si l'élément errors n'est pas vide $form->isValid renverra false
        $form->handleRequest($request);

        //Gestion de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            // on upload la nouvelle image d'en-tête
            $this->get('file.uploader')->upload($article);
            if(!$article->getHeaderImage()) {
                $article->setHeaderImage($articleImgPath);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'article a bien été mis à jour et sauvegardé en base de donnée!");

            // Toujours rediriger après soumission de formulaire
            // Si le formulaire est soumis et valide on redirige sur la visualisation de l'article
            // Si redirection dans le même contrôleur utiliser plutot forward : comme redirect 
            // Va utiliser une master request mais en gardant le contexte de la requête précédente
            return $this->redirectToRoute(
                'article_show', 
                ['id' => $article->getId()]
            );
        }
    
        // Si le formulaire n'est pas valide on affiche à nouveau le formulaire
        return $this->render(
            'article/add.html.twig',
            [
                'form' => $form->createView(),
                'article' => $article,
                'oldArticleImgPath' => $articleImgPath
            ]
        );
    }

}
