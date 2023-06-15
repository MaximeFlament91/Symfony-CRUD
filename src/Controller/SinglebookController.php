<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SinglebookController extends AbstractController
{
    /**
     * @Route("/singlebook/{id}", name="app_singlebook")
     */
    public function index($id, EntityManagerInterface $manager): Response
    {
        $book = $manager->getRepository(Book::class)->find($id);
        // find() permet de recuperer une ligne de la table qu'on spécifie
        // la il récupere le livre par son ID qui est dans l'Url
        // SELECT * FROM book WHERE id = idUrl
        return $this->render('singlebook/index.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/singlebook/remove/{id}", name="app_singlebook_remove")
     */
    public function remove($id, EntityManagerInterface $manager)
    {
        // 0 recuperer l'article en question
        $book = $manager->getRepository(Book::class)->find($id);
        // 1 supprimer l'article en question
        $manager->remove($book);
        $manager->flush();
        // 2 rediriger sur la page d'acceuil
        return $this->redirectToRoute('app_home');
        // dd('fonction qui supprime'.$id);
    }
}
