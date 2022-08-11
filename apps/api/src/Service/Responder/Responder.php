<?php

namespace App\Service\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Get responses for event subscriber
 */
class Responder
{
    public function getErrorJsonResponse(string|array $message, int $statusCode): JsonResponse
    {
        $message = [
            'error' => $message,
        ];

        /** @var JsonResponse $response */
        $response = new JsonResponse($message, $statusCode);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
