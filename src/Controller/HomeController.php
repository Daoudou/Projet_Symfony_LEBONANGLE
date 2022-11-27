<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Advert;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(?Advert $advert,AdvertRepository $advertRepository ): Response
    {
        $advertGeneral = $advertRepository->findAll();
        return $this->render('home/home.html.twig', [
            'controller_name' => 'LEBONANGLE',
            'allAdvert' => $advertGeneral,
        ]);
    }
}
