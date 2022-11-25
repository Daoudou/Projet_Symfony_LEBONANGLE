<?php

namespace App\Controller;

use App\Form\AdminUserFormType;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AdminUser;

class RegistrationController extends AbstractController
{
    #[Route('/', name: 'app_page_admin')]
    public function index(?AdminUser $adminUser,AdminUserRepository $adminUserRepository, Request $request,EntityManagerInterface $entityManager): Response
    {

        $adminUser = $adminUserRepository->findAll();
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'Page d enregistrement ',
            'allAdmin' => $adminUser,
        ]);
    }

    #[Route('/registration', name: 'app_registration')]
    public function addAdminUser(UserPasswordHasherInterface $passwordHasher,AdminUserRepository $adminUserRepositoryAdd, Request $request,EntityManagerInterface $entityManager){

        $adminUser = new AdminUser();

        $form = $this->createForm(AdminUserFormType::class,$adminUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $plainPassword = $form->get('plainpassword');
            $hashedPassword = $passwordHasher->hashPassword(
                $adminUser,
                $adminUser->getPlainPassword()
            );
            $adminUser->setPassword($hashedPassword);
            $entityManager->persist($adminUser);
            $entityManager->flush();
        }



        return $this->render('registration/add.html.twig', [
            'controller_name' => 'Page d enregistrement ',
            'form' => $form->createView(),
        ]);
    }

}
