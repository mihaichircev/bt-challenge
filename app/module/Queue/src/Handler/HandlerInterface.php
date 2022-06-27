<?php

namespace Queue\Handler;

interface HandlerInterface
{
    /**
     * @param mixed $message
     */
    public function handle($message): void;
}
