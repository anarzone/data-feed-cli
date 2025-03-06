<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException($event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidationFailedException){
            $response = new JsonResponse([
                "status" => "error",
                'message' => 'Validation failed',
                'errors' => $this->formatValidationErrors($exception->getViolations())
            ], Response::HTTP_BAD_REQUEST);

            $event->setResponse($response);
        }
    }

    private function formatValidationErrors(ValidationFailedException $exception): array
    {
        $errors = [];

        foreach ($exception->getViolations() as $violation) {
            $errors[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
                'value' => $violation->getInvalidValue(),
                'constraint' => $violation->getConstraint(),
                'code' => $violation->getCode(),
            ];
        }

        return $errors;
    }
}
