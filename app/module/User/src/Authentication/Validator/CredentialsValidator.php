<?php

namespace User\Authentication\Validator;

use Common\Exception\NotFoundException;
use User\Authentication\Result;
use User\Authentication\Session;
use User\Service\OtpService;
use User\Service\UserService;

class CredentialsValidator implements AuthenticationValidatorInterface
{
    private Result $result;

    public function __construct(
        private UserService $userService,
        private Session $session
    ) {
        $this->result = new Result();
    }

    public function validate(mixed $args): Result
    {
        // user not found
        try {
            $user = $this->userService->loadByUsername($args['username']);
        } catch (NotFoundException $e) {
            return $this->result->error(Result::CODE_INVALID_CREDENTIALS);
        }
        // wrong password
        if (! $user->credentialsCheck($args['password'])) {
            return $this->result->error(Result::CODE_INVALID_CREDENTIALS);
        }
        // write the user in session for next step
        if (null !== $user->getId()) {
            $this->session->setRequesterId($user->getId());
        }

        return $this->result->success();
    }
}
