<?php

namespace App\Controller;

use App\Form\AdminUserFormType;
use App\Form\LoginFormType;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AdminUser;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_page_admin')]
    public function index(?AdminUser $adminUser,AdminUserRepository $adminUserRepository, Request $request,EntityManagerInterface $entityManager): Response
    {

        $adminUser = $adminUserRepository->findAll();
        return $this->render('admin/home.html.twig', [
            'controller_name' => 'Page d enregistrement ',
            'allAdmin' => $adminUser,
        ]);
    }

    #[Route('/admin/edit/{id}',name: 'app_edit')]
    public function editUser(?AdminUser $adminUser,UserPasswordHasherInterface $passwordHasher,AdminUserRepository $adminUserRepository,Request $request,EntityManagerInterface $entityManager) : Response{

        if (!$adminUser){
            $adminUser = new AdminUser();
        }

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

        $adminUserEdit = $adminUserRepository->find($request->attributes->get('id'));

        return $this->render('registration/edit.html.twig',[
            'editLayoutName' => 'Edition',
            'form' => $form->createView(),
            'userEdit' => $adminUserEdit
        ]);

    }

    #[Route('/admin/delete/{id}',name: 'app_delete')]
    public function deleteUser(AdminUserRepository $adminUserRepository,Request $request,EntityManagerInterface $entityManager) : Response{

        $adminUser = $adminUserRepository->find($request->attributes->get('id'));
        $editUser = $adminUserRepository->remove($adminUser,true);
        return $this->redirectToRoute('app_page_admin');
    }

}
