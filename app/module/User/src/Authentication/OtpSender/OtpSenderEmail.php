<?php

namespace User\Authentication\OtpSender;

use Common\Service\EmailService;
use Common\Service\MessageService;
use User\Entity\Otp;

class OtpSenderEmail implements SenderInterface
{
    public function __construct(private EmailService $emailService)
    {
    }

    public function send(Otp $otp): void
    {
        $this->emailService->send(
            MessageService::TYPE_OTP_TOKEN,
            ['token' => $otp->getToken()],
            $otp->getUser()->getEmail()
        );
    }
}
