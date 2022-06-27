<?php

namespace User\Authentication\Service;

use User\Authentication\Validator\AuthenticationValidatorInterface;
use User\Authentication\Result;
use User\Authentication\Session;
use User\Entity\User;
use User\Service\UserService;

class AuthenticationService
{
    public const CHECK_CREDENTIALS = 0;
    public const CHECK_OTP_LIMIT = 1;
    public const CHECK_OTP = 2;

    /**
     * @var Array<AuthenticationValidatorInterface>
     */
    private array $validators = [];

    public function __construct(private Session $session, private UserService $userService)
    {
    }

    /**
     * @param Array<AuthenticationValidatorInterface> $validators
     */
    public function setValidators(array $validators): void
    {
        $this->validators = $validators;
    }

    public function validate(int $step, mixed $args = null): Result
    {
        return $this->validators[$step]->validate($args);
    }

    public function getIdentity(): User
    {
        return $this->userService->loadById($this->session->getIdentity());
    }

    public function hasIdentity(): bool
    {
        return $this->session->hasIdentity();
    }

    public function clearIdentity(): void
    {
        $this->session->clearIdentity();
    }
}
