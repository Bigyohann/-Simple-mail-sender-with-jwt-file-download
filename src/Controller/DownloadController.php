<?php

namespace App\Controller;

use App\Dto\DownloadDto;
use App\Service\JwtService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    #[Route('/download', name: 'app_download')]
    public function index(#[MapQueryString] DownloadDto $dto, JwtService $jwtService): Response
    {
        if (!$jwtService->decode($dto->token)){
            throw new UnauthorizedHttpException('Token is not valid');
        }

        // TODO Serve file here
        return $this->json([
            'download' => 'blabla'
        ]);
    }
}
