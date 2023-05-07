<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserAuthenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    /**
     * Override to change the request conditions that have to be
     * matched in order to handle the login form submit.
     *
     * This default implementation handles all POST requests to the
     * login path (@see getLoginUrl()).
     */
    public function supports(Request $request): bool
    {
        return $request->isMethod('POST');
    }

    /**
     * Override to change what happens after a bad username/password is submitted.
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if ($request->hasSession()) {
            $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);
        }

        return new JsonResponse(['roles' => []], 401);
    }

    public function authenticate(Request $request): Passport
    {
        $name = $request->request->get('name', '');

        $request->getSession()->set(Security::LAST_USERNAME, $name);

        return new Passport(
            new UserBadge($name),
            new PasswordCredentials($request->request->get('password', ''))
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new JsonResponse(['roles' => $token->getUser()->getRoles()]);
    }
}
