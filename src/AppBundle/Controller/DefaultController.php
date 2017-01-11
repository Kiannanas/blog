<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', ['message' => "Hello"]);
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
        return $this->render('default/show.html.twig', ['id' => $id]);
    }

    /**
    * @Route(
    *    "/users",
    *    name="users",
    *    requirements={"id" : "\d+"},
    *    defaults={"id" : 1})
    */
    public function userAction()
    {
        //return new Response("Hello", 500, ['X-my-header' => 'Youhouu j\' ai fait mon propre header']);
        //Mieux pour la lisibilité d'utiliser les constantes
        return new Response("Hello", Response::HTTP_OK, ['X-my-header' => 'Youhouu j\' ai fait mon propre header']);
    }

}
