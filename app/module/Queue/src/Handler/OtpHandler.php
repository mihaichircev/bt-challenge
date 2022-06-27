<?php

namespace Queue\Handler;

use User\Authentication\OtpSender\SenderInterface;
use User\Service\OtpService;

class OtpHandler implements HandlerInterface
{
    public function __construct(
        private SenderInterface $sender,
        private OtpService $otpService
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function handle($message): void
    {
        $otp = $this->otpService->loadById($message);
        $this->sender->send($otp);
    }
}
