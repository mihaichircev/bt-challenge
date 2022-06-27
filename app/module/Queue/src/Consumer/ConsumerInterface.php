<?php

namespace Queue\Consumer;

interface ConsumerInterface
{
    public function read(string $name, string $queue): void;
}
