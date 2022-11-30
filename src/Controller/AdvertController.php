<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Form\AdvertFormType;
use App\Repository\AdminUserRepository;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertController extends AbstractController
{
    #[Route('/advert/add', name: 'app_advert')]
    public function addAdvert(AdminUserRepository $adminUserRepositoryAdd, Request $request,EntityManagerInterface $entityManager): Response
    {
        $advert = new Advert();
        
        $form = $this->createForm(AdvertFormType::class,$advert);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $advert->setState('draft');
            $advert->setCreatedAt(new \DateTime());

            $entityManager->persist($advert);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('advert/add.html.twig', [
            'controller_name' => 'AdvertController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/advert/edit/{id}', name: 'app_edit_advert')]
    public function editCategory(?Advert $advert,AdvertRepository $advertRepository,
                                 Request $request,EntityManagerInterface $entityManager): Response
    {
        if (!$advert){
            $advert = new Advert();
        }

        $form = $this->createForm(AdvertFormType::class,$advert);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($advert);
            $entityManager->flush();

            return $this->redirectToRoute('app_page_admin');
        }

        $editCategory = $advertRepository->find($request->attributes->get('id'));

        return $this->render('category/edit.html.twig',[
            'editLayoutName' => 'Edition de la categorie',
            'form' => $form->createView(),
            'categoryEdit' => $editCategory,
        ]);

    }

    #[Route('/advert/delete/{id}', name: 'app_delete_advert')]
    public function deleteCategory(?Advert $advert,AdvertRepository $advertRepository,
                                   Request $request,EntityManagerInterface $entityManager): Response
    {
        $advert = $advertRepository->find($request->attributes->get('id'));
        $advertDelete = $advertRepository->remove($advert,true);
        return $this->redirectToRoute('app_page_admin');
    }
}
