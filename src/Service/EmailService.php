<?php

namespace App\Service;

use DateInterval;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class EmailService
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly JwtService      $jwtService,
        private readonly Environment     $twig,
        private readonly UrlGeneratorInterface $urlGenerator
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMail(string $to)
    {
        $email = (new Email())
            ->to($to)
            ->subject('Time for Symfony Mailer!')
            ->html($this->twig->render('email/downloadFile.html.twig',
                [
                    'url' => $this->urlGenerator->generate('app_download', [], UrlGeneratorInterface::ABSOLUTE_URL),
                    'token' => $this->jwtService->encode(
                        [
                            'to' => $to,
                            'exp' => (new \DateTime())->add(DateInterval::createFromDateString('2592000 seconds'))->getTimestamp()
                        ]
                    )
                ]
            ));

        $this->mailer->send($email);
    }
}
