<?php

namespace App\Service\Responder;

use App\Entity\Product;
use App\Service\JWT\TokenInspector;
use Doctrine\Persistence\ManagerRegistry;
use App\Exception\RessourceNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * Responder
 * Set responses for event subscriber.
 * @package App\Service\Responder
 */
class Responder
{
    private ManagerRegistry $managerRegistry;

    private TokenInspector $tokenInspector;

    public function __construct(ManagerRegistry $managerRegistry, TokenInspector $tokenInspector)
    {
        $this->managerRegistry  = $managerRegistry;
        $this->tokenInspector   = $tokenInspector;
    }

    /**
     * Set unauthorized response if user is not ressource owner,
     * and stop event propagation.
     *
     * @param string       $class is class name resolution (e.g. Product::class)
     * @param string       $httpMethod (e.g. Request::METHOD_GET)
     * @param array        $options [token, route, event]
     *
     * @return void
     */
    public function setUnauthorizedItemOperationsResponse(string $class, string $httpMethod, array $options): void
    {
        // Route from class name resolution and method(e.g. api_products_get_item)
        $itemCategoryRoute = $this->getItemOperationsRoute($this->getRessourceName($class), $httpMethod);

        /** @var RequestEvent $event */
        $event = $options['event'];

        if (null != $options['token'] && $options['route'] === $itemCategoryRoute) {
            if (null === $this->getRessource($class, $event)) {
                $event->setResponse($this->getErrorJsonResponse(
                    'Ressource not found.',
                    404
                ));
                return;
            }

            $userId  = $this->tokenInspector->getUserIdFromToken($options['token']);
            $ownerId = $this->getRessource($class, $event)->getOwner()->getId();

            if ($userId !== $ownerId) {
                $event->setResponse($this->getErrorJsonResponse(
                    'Requested ressource is not your own.',
                    401
                ));
            }
        }
    }

    /**
     * Get error JSON response
     *
     * @param string|array $message
     * @param integer      $statusCode
     *
     * @return JsonResponse
     */
    public function getErrorJsonResponse(string|array $message, int $statusCode): JsonResponse
    {
        /** @var JsonResponse $response */
        $response = new JsonResponse(['error' => $message], $statusCode);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Get a ressource entity from class name resolution and request event
     *
     * @param string       $class is class name resolution (e.g. Product::class)
     * @param RequestEvent $event
     *
     * @return object|null
     */
    private function getRessource(string $class, RequestEvent $event): ?object
    {
        $requestedUri  = $event->getRequest()->getRequestUri();
        $ressourceName = $this->getRessourceName($class);
        $ressourceId   = (int)preg_replace("/api$ressourceName/", '', str_replace('/', '', $requestedUri));
        /** @phpstan-ignore-next-line */
        return $this->managerRegistry->getRepository($class)->find($ressourceId);
    }

    /**
     * Get a ressource name from a class name resolution
     *
     * @param string $class is class name resolution (e.g. Product::class)
     *
     * @return string
     */
    private function getRessourceName(string $class): string
    {
        $className = preg_replace('/AppEntity/', '', stripslashes($class));
        $nameConverter = new CamelCaseToSnakeCaseNameConverter();
        $snakecase = $nameConverter->normalize($className);
        return $snakecase . 's';
    }

    /**
     * Get a route from class name resolution and http method
     * for item operation category
     *
     * @param string $class is class name resolution (e.g. Product::class)
     * @param string $httpMethod (e.g. Request::METHOD_GET)
     *
     * @return string
     */
    private function getItemOperationsRoute(string $class, string $httpMethod): string
    {
        return 'api_' . $class . '_' . strtolower($httpMethod) . '_item';
    }
}
