<?php

namespace Queue\Consumer;

use DateTime;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Queue\Handler\HandlerInterface;

class RabbitMQConsumer implements ConsumerInterface
{
    /**
     * @var HandlerInterface[]
     */
    private $handlers = [];

    public function __construct(private AMQPStreamConnection $connection)
    {
    }

    /**
     * @param HandlerInterface[] $handlers
     */
    public function setHandlers($handlers): void
    {
        $this->handlers = $handlers;
    }

    public function read(string $name, string $queue): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queue, false, false, false, false);
        $this->log("RabbitMQ subscribed to queue '{$name}' with registered as '{$queue}'");

        $callback = function ($message) use ($name) {
            $this->log("RabbitMQ message received on queue '{$name}'");
            $this->handlers[$name]->handle(json_decode($message->body, true));
        };

        $channel->basic_consume($queue, '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }

    protected function log(string $message): void
    {
        $time = (new DateTime())->format('d-m-Y H:i:s');
        echo "$time - $message\n";
    }
}
