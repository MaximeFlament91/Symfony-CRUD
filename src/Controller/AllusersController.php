<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllusersController extends AbstractController
{
    /**
     * @Route("/allusers", name="app_allusers")
     */
    public function index(): Response
    {
        return $this->render('allusers/index.html.twig', [
            'controller_name' => 'AllusersController',
        ]);
    }
}
