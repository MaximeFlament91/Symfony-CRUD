<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(EntityManagerInterface $manager, UserRepository $uRepo, BookRepository $bRepo): Response
    {
        // recuperer toutes les données d'une table
        $books = $manager->getRepository(Book::class)->findAll();
        // $user = $uRepo->findByLastname('gjjlkhjk');
        // $book = $bRepo->findByTitle('mflflflf');
        // $bookTotal= $bRepo->findTotal();
        // dd($bookTotal);
        // dd($book);
        // dd($user);
        // SELECT * from book
        // findAll() permet de recuperer toutes la table
        //dd($books);
        return $this->render('home/index.html.twig', [
            'books' => $books,
        ]);
    }
}
