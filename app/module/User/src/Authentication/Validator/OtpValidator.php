<?php

namespace User\Authentication\Validator;

use Common\Exception\NotFoundException;
use User\Authentication\Result;
use User\Authentication\Session;
use User\Service\OtpService;
use User\Service\UserService;

class OtpValidator implements AuthenticationValidatorInterface
{
    private Result $result;

    public function __construct(
        private UserService $userService,
        private OtpService $otpService,
        private Session $session
    ) {
        $this->result = new Result();
    }

    public function validate(mixed $token): Result
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
        // get the latest otp
        $otp = $user->getOtps()->first();
        // otp not found
        if (null === $otp || $otp->getToken() !== $token) {
            return $this->result->error(Result::CODE_OTP_INVALID);
        }
        // otp expired
        if (! $otp->isValid()) {
            return $this->result->error(Result::CODE_OTP_EXPIRED);
        }
        // write the user in session for next step
        $this->session->setIdentity($this->session->getRequesterId());
        // clear the requesterId
        $this->session->clearRequesterId();
        // remove OTP from db
        $this->otpService->remove($otp);

        return $this->result->success();
    }
}
