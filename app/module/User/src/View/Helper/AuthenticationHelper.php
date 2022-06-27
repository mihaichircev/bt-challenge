<?php

namespace User\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use User\Authentication\Service\AuthenticationService;

class AuthenticationHelper extends AbstractHelper
{
    public function __construct(private AuthenticationService $authenticationService)
    {
    }

    public function __invoke(): AuthenticationService
    {
        return $this->authenticationService;
    }
}
