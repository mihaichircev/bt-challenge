<?php

namespace User\Authentication\Validator;

use User\Authentication\Result;

interface AuthenticationValidatorInterface
{
    public function validate(mixed $args): Result;
}
