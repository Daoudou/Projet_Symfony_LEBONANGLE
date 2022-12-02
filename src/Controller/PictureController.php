<?php

namespace App\Controller;

use App\Entity\Picture;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class PictureController extends AbstractController
{
    public function __invoke(Request $request): Picture{
        $uploadFile = $request->files->get('file');
        if(!$uploadFile){
            throw new BadRequestException('"file" is required');
        }

        $picture = new Picture();
        $picture->setFile($uploadFile);
        $picture->setPath("Ton Ordi debile");
        $picture->setCreateAt(new DateTimeImmutable());

        return $picture;
    }
}
