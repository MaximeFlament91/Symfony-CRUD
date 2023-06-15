<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $request,EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHash): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $passwordClear = $user->getPassword(); // je recupere le MDP en clair
            $passwordIsHashed = $passwordHash->hashPassword($user,$passwordClear); // je hash le MDP
            $user->setPassword($passwordIsHashed); // je remplace le MDP en clair par le DMP saisi
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('succes', 'L\'utilisateur a bien été ajouté');
            $form = $this->createForm(RegisterType::class, new User());

        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
