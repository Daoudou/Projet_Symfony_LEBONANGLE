<?php

namespace App\Tests;

use App\Entity\Advert;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class AdvertTest extends TestCase
{
    
    public function testAddAdvert():void{
        $advert = new Advert();
        $category = new Category();
        
        $advert->setTitle("Elden Ring");
        $advert->setContent("Absolument Genial se jeux");
        $advert->setAuthor("Daoudou");
        $advert->setEmail("dada@gmail.com");
        //$advert->setCategory($category->getId(4));
        $advert->setCategory($category->getId());
        $advert->setPrice(45);
        $advert->setState('draft');
        $advert->setCreatedAt(new \DateTime());
        $advert->setPublishedAt(new \DateTime());
        
        // Je rajoute une truc 

        $advertRepository = $this->createMock(ObjectRepository::class);
        $advertRepository->expects($this->any())
            ->method('find')
            ->willReturn($advert);

        $objectManager = $this->createMock(ObjectManager::class);

        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($advert);
        
    }

}
