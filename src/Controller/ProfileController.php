<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', []);
    }



    /**
     * @Route("/profile", name="app_redirect")
     */
    public function redirectTo(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
        return $this->redirectToRoute('app_dashboard');
        }else{
        return $this->redirectToRoute('app_profile');
        }
    }
}
