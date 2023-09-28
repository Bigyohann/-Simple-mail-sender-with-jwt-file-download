<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class MailDto
{
    public function __construct(
        #[Assert\Email]
        #[Assert\NotNull]
        public string $mail
    )
    {
    }
}
