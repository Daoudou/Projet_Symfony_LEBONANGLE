<?php

namespace App\Controller;

use App\Form\AdminUserFormType;
use App\Entity\AdminUser;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function addAdminUser(UserPasswordHasherInterface $passwordHasher,AdminUserRepository $adminUserRepositoryAdd, Request $request,EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse|Response
    {

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

            return $this->redirectToRoute('app_page_admin');
        }

        return $this->render('registration/add.html.twig', [
            'controller_name' => 'Page d enregistrement ',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function loginUser(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUserName,
            'error'         => $error,
            'user' => $user,
        ]);
    }
}