<?php

namespace App\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ValidationExceptionListener
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable()->getPrevious();
        if (!$exception instanceof ValidationFailedException) {
            return;
        }

        $errors = [];
        foreach ($exception->getViolations() as $violation) {
            if (!$violation->getPropertyPath()) {
                continue;
            }
            $errors[$violation->getPropertyPath()]['name'] = $violation->getPropertyPath();
            $errors[$violation->getPropertyPath()]['errors'][] = [
                'code' => $violation->getCode(),
                'message' => $violation->getMessage(),
            ];
        }

        $response = new JsonResponse(
            $this->serializer->serialize([
                'message' => 'validation failed',
                'errors' => $errors,
            ], 'json'),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            json: true
        );

        $event->setResponse($response);
    }
}
