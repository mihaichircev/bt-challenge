<?php

namespace User\Authentication\Validator;

use Common\Exception\NotFoundException;
use User\Authentication\Result;
use User\Authentication\Session;
use User\Service\OtpService;
use User\Service\UserService;

class OtpLimitValidator implements AuthenticationValidatorInterface
{
    private Result $result;

    public function __construct(
        private UserService $userService,
        private OtpService $otpService,
        private Session $session
    ) {
        $this->result = new Result();
    }

    public function validate(mixed $args = null): Result
    {
        // user is not in session
        if (! $this->session->hasRequesterId()) {
            return $this->result->error(Result::CODE_USER_INVALID);
        }
        try {
            $user = $this->userService->loadById($this->session->getRequesterId());
        } catch (NotFoundException $e) {
            return $this->result->error(Result::CODE_USER_INVALID);
        }
        // token generation limit reached
        if ($user->isOtpLimitReached()) {
            return $this->result->error(Result::CODE_OTP_LIMIT_REACHED);
        }
        // generate token
        if (null !== $user->getId()) {
            $this->otpService->generateOtp($user->getId());
        }

        return $this->result->success();
    }
}
