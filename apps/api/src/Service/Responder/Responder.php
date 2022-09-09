<?php

namespace App\Service\Responder;

use App\Service\JWT\TokenInspector;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
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
    public function setUnauthorizedItemCategory(string $class, string $httpMethod, array $options): void
    {
        // Route from class name resolution and method(e.g. api_products_get_item)
        $itemCategoryRoute = $this->getItemCategoryRoute($this->getRessourceName($class), $httpMethod);

        if (null != $options['token'] && $options['route'] === $itemCategoryRoute) {
            $userId  = $this->tokenInspector->getUserIdFromToken($options['token']);
            $ownerId = $this->getRessource($class, $options['event'])->getOwner()->getId();

            if ($userId !== $ownerId) {
                $options['event']->setResponse($this->getErrorJsonResponse(
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
     * Get an entity (ressource object) from class n ame resolution and request event
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
     * Get a route from class name resolution, http method and operation category
     *
     * @param string $class is class name resolution (e.g. Product::class)
     * @param string $httpMethod (e.g. Request::METHOD_GET)
     *
     * @return string
     */
    private function getItemCategoryRoute(string $class, string $httpMethod): string
    {
        return 'api_' . $class . '_' . strtolower($httpMethod) . '_item';
    }
}
