<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as Response;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;

/**
* @Route("/article", name="article")
*/
class ArticleController extends Controller
{
    /**
     * @Route("/", name="homepage_article")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('article/index.html.twig', array('message' => "Hello"));
    }

    /**
    * @Route(
    *    "/{id}",
    *    name="show_article",
    *    requirements={"id" : "\d+"},
    *    defaults={"id" : 1})
    */
    public function showAction($id)
    {
        dump($id);
        return $this->render('article/show.html.twig', array('id' => $id));
    }

    /**
    * @Route(
    *    "/add",
    *    name="add_article")
    */
    public function addAction(Request $request)
    {
        //Construction du formulaire
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        //on configure le bouton de soumission de formulaire dans add.html.twig
        //car ça relève de l'affichage donc n'a rien à faire dans du php
        //pour pouvoir le modifier dans le cas d'une modification d'article
        // form->add('submit', SubmitType::class, array(
        //     'label' => 'Créer l\'article',
        //     'attr'  => array('class' => 'btn btn-default pull-right')
        // ));

        $form->handleRequest($request);

        //Gestion de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            //Si le formulaire est soumis et valide on redirige sur la visualisation de l'article
            return $this->redirect(
                $this->generateUrl(
                    'show_article',
                    array('id' => $article->getId())
                )
            );
        }
    
        //Si le formulaire n'est pas valide on affiche à nouveau le formulaire
        return $this->render('article/add.html.twig', array('form' => $form->createView()));
    }

}
