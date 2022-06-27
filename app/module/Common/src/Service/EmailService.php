<?php

namespace Common\Service;

use Laminas\Mail\Transport\TransportInterface;

class EmailService
{
    public function __construct(private TransportInterface $transport, private MessageService $messageService)
    {
    }

    /**
     * @param Array<mixed> $data
     */
    public function send(int $type, array $data, string $email): void
    {
        $this->transport->send($this->messageService->getMessage($type, $data, $email));
    }
}
