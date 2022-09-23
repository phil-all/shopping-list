<?php

namespace App\Service\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\Token\JWTPostAuthenticationToken;

/**
 * TokenInspector
 * Inspect JWT token
 * @package App\Service\JWT
 */
class TokenInspector
{
    private JWTTokenManagerInterface $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    /**
     * Get User id from JWT token
     *
     * @param JWTPostAuthenticationToken $token
     *
     * @return integer
     */
    public function getUserIdFromToken(JWTPostAuthenticationToken $token): int
    {
        return $this->jwtManager->decode($token)['id'];
    }
}
