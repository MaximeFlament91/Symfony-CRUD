<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Book;
use App\Form\BookType;
use App\Service\Mailjet;
use App\Entity\Notification;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AddbookController extends AbstractController
{
    /**
     * @Route("/addbook", name="app_addbook")
     */
    public function index(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, UserRepository $userRepository, Mailjet $mailjet): Response
    {
        // EntityManagerInterface permet de gerer les données de la base de données
        // ici ont crée un objet Book
        $book = new Book();
        //ont crée un formulaire à partir de la classe BookType
        $form = $this->createForm(BookType::class, $book);
        // ont récupéré les données du formulaire
        $form->handleRequest($request);

        // ont vérifié si le formulaire à été soumis
        if ($form->isSubmitted()) {
            $picture = $form->get('picture')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $book->setPicture($newFilename);
            }
            $book->setCreatedAt(new \DateTime('Europe/Paris'));
            // persist permet de preparer les données à etre inserer dans la base de données
            $manager->persist($book);
            // flush permet d'envoyer les données dans la base de données
            $manager->flush();
            // on affiche un message flash pourconfirmer l'ajout du formulaire
            $this->addFlash('success', 'Le livre a bien été ajouté');

            // recuperation des mes users
            $admins =$userRepository->findByRole('ROLE_ADMIN');
            // ont instancie un objet notification


            // ont boucle sur les users pour recuperer les admins et leur envoyer une notification
            foreach ($admins as $admin) {

                $notification = new Notification();
                $notification->setSubject('Nouveau livre ajouté');
                $notification->setContent('Un nouveau livre a été ajouté' . ' ' . $book->getTitle());
                $notification->setCreatedAt(new DateTime('Europe/Paris'));
                $notification->setReciver($admin);
                $manager->persist($notification);
                $manager->flush();
                $mailjet->sendEmail($admin, 'un nouceau livre à été ajouté' . ' ' . $book->getTitle());
            }
            // on vide le formulaire
            $form = $this->createForm(BookType::class, new Book());
        }
        return $this->render('addbook/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}