<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditbookController extends AbstractController
{
    /**
     * @Route("/editbook/{id}", name="app_editbook")
     */
    public function remove($id, EntityManagerInterface $manager,Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $book->setCreatedAt(new \DateTime());
            $manager->persist($book);
            $manager->flush();
            return $this->redirectToRoute('app_singlebook',['id'=>$book->getId()]);
        }
        return $this->render('editbook/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
