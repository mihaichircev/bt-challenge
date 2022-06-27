<?php

namespace User\Authentication;

class Result
{
    public const CODE_INVALID_CREDENTIALS = 1;
    public const CODE_USER_INVALID = 2;
    public const CODE_OTP_LIMIT_REACHED = 3;
    public const CODE_OTP_INVALID = 4;
    public const CODE_OTP_EXPIRED = 5;

    /**
     * @var Array<string> $messages
     */
    protected array $messages = [
        self::CODE_INVALID_CREDENTIALS => 'The credentials provided are invalid',
        self::CODE_USER_INVALID => 'The user is invalid',
        self::CODE_OTP_LIMIT_REACHED =>
            'You have exceed the limit of generated tokens in the past 30 minutes. Please try again later.',
        self::CODE_OTP_INVALID => 'The token you provided is invalid. Please try again.',
        self::CODE_OTP_EXPIRED => 'The token you provided is expired. Please generate another one.',
    ];

    protected bool $valid = false;
    protected ?string $message;
    protected int $code;

    public function success(): Result
    {
        $this->valid = true;

        return $this;
    }

    public function error(int $code): Result
    {
        $this->valid = false;
        $this->code = $code;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->messages[$this->code];
    }
}
