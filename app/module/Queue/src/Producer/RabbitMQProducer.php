<?php

namespace Queue\Producer;

use Laminas\Json\Json;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQProducer implements ProducerInterface
{
    public function __construct(private AMQPStreamConnection $connection)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function send($message, string $queue): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queue, false, false, false, false);

        $msg = new AMQPMessage(Json::encode($message));

        $channel->basic_publish($msg, '', $queue);
        $channel->close();
    }
}
