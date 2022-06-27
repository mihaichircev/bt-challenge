<?php

namespace Queue\Producer;

interface ProducerInterface
{
    /**
     * @param mixed $message
     * @param string $queue
     */
    public function send($message, string $queue): void;
}
