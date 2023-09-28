<?php

namespace App\Controller;

use App\Dto\MailDto;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/mail', name: 'app_mail', methods: ['POST'])]
    public function index(#[MapRequestPayload] MailDto $mailDto, EmailService $emailService): JsonResponse
    {
        $emailService->sendMail($mailDto->mail);

        return $this->json([
            'status' => 'processed'
        ]);
    }
}
