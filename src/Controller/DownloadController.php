<?php

namespace App\Controller;

use App\Dto\DownloadDto;
use App\Service\JwtService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    #[Route('/download', name: 'app_download')]
    public function index(#[MapQueryString] DownloadDto $dto, JwtService $jwtService, #[Autowire('%kernel.project_dir%')] $dir,
    ): Response
    {
        if (!$jwtService->decode($dto->token)){
            throw new UnauthorizedHttpException('Token is not valid');
        }

        return $this->file($dir.'/public/test.txt', 'download.txt');
    }
}
