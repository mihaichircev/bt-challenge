<?php

namespace Common\Service;

use User\Entity\User;
use User\Authentication\Service\AuthenticationService;

class AuthorizationService
{
    /**
     * @var Array<mixed>
     */
    private array $config = [];

    public function __construct(private AuthenticationService $authenticationService)
    {
    }

    /**
     * @param Array<mixed> $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * @return Array<mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    public function isAllowed(string $route): bool
    {
        $role = $this->getRole();

        if (isset($this->config['routes'][$route])) {
            return $this->roleHasRoute($role, $route);
        }

        return false;
    }

    private function getRole(): int
    {
        return $this->authenticationService->hasIdentity() ? User::ROLE_USER : User::ROLE_GUEST;
    }

    private function roleHasRoute(int|null $role, string $route): bool
    {
        return $role === null ? false : $this->config['routes'][$route] === $role
            || $this->roleHasRoute($this->config['roles'][$role]['parent'], $route);
    }
}
