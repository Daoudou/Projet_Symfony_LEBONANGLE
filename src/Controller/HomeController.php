<?php

namespace App\Controller;

use App\Repository\AdminUserRepository;
use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Advert;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AdvertRepository $advertRepository ): Response
    {
        $advertGeneral = $advertRepository->findAll();
        return $this->render('home/home.html.twig', [
            'controller_name' => 'LEBONANGLE',
            'allAdvert' => $advertGeneral,
        ]);
    }

    #[Route('/show/advert/{id}', name: 'app_show_advert')]
    public function showAdvert(AdvertRepository $advertRepository,Request $request) : Response{
        
        $advertShow = $advertRepository->find($request->attributes->get('id'));
        return $this->render('home/show.html.twig',[
            'showLayoutName' => 'Affichage',
            'advert' => $advertShow,
        ]);
    }
}
