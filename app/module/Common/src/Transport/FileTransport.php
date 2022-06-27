<?php

namespace Common\Transport;

use DateTime;
use Laminas\Mime;
use Laminas\Mail\Message;
use Laminas\Mail\Transport\TransportInterface;

class FileTransport implements TransportInterface
{
    private const FILE_FORMAT = '%s/%s_message.html';
    /**
     * @var Array<mixed> $config
     */
    private array $config = [];

    public function send(Message $message): void
    {
        $now = new DateTime();
        $fileName = sprintf(self::FILE_FORMAT, $this->config['path'], $now->format('Y_m_d_h_i'));
        /**
         * @var Mime\Message $body
         */
        $body = $message->getBody();
        file_put_contents($fileName, $body->getParts()[0]->getContent());
    }

    /**
     * @param Array<mixed> $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
