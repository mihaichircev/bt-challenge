<?php

namespace Common\Service;

use Laminas\Mail\Message;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\Mime;

class MessageService
{
    public const TYPE_OTP_TOKEN = 1;
    private const DEFAULT_CHARSET = 'utf-8';

    /**
     * @var Array<mixed>
     */
    private array $config = [];

    public function __construct(private ViewModel $viewModel, private PhpRenderer $renderer)
    {
    }

    /**
     * @param Array<mixed> $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * @param Array<mixed> $data
     */
    public function getMessage(int $type, array $data, string $email): Message
    {
        $message = new Message();
        $metadata = $this->config['types'][$type];
        $message->setSubject($metadata['subject']);
        $message->setFrom($this->config['from'], $this->config['from_name']);
        $message->setTo($email);

        $body = $this->render($metadata['template'], $data);
         // Create a Mime\Part and wrap it into a Mime\Message
        $mimePart = new Mime\Part($body);
        $mimePart->type = $body != strip_tags($body) ? Mime\Mime::TYPE_HTML : Mime\Mime::TYPE_TEXT;
        $mimePart->charset = self::DEFAULT_CHARSET;
        $body = new Mime\Message();
        $body->setParts([$mimePart]);
        $message->setBody($body);

        return $message;
    }

    /**
     * @param Array<mixed> $data
     */
    private function render(string $template, array $data): string
    {
        $this->viewModel->setTerminal(true)
            ->setTemplate($template)
            ->setVariables($data);

        return $this->renderer->render($this->viewModel);
    }
}
