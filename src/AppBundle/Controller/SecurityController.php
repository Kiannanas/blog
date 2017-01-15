<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // Get the last authentication error, if occured.
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user 
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'login_error' => $error,
            'last_username' => $lastUsername
        ]);
    }
    /**
     * @Route("/article/admin/auth-check", name="authentication_check")
     */
    public function loginCheckAction()
    {
        // This code will never be executed
    }
    /**
     * @Route("/article/admin/logout", name="logout")
     */
    public function logoutAction()
    {
        // This code will never be executed
    }
}