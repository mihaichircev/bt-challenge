<?php

namespace User\Authentication\OtpSender;

use User\Entity\Otp;

interface SenderInterface
{
    public function send(Otp $otp): void;
}
