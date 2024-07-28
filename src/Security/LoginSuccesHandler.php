<?php

namespace App\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\HttpUtils;

class LoginSuccesHandler implements AuthenticationSuccessHandlerInterface
{
    private $httpUtils;

    public function __construct(HttpUtils $httpUtils)
    {
        $this->httpUtils = $httpUtils;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        // Custom logic on successful authentication
        $user = $token->getUser();

        // Redirect based on user role
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->httpUtils->createRedirectResponse($request, 'app_admin_welcome');
        } else {
            return $this->httpUtils->createRedirectResponse($request, 'app_user_welcome');
        }
    }
}
