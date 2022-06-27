<?php

namespace Queue\Command;

use Queue\Consumer\ConsumerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class QueueCommand extends Command
{
    /**
     * @var mixed[]
     */
    protected $config = [];

    /**
     * {@inheritDoc}
     */
    protected static $defaultName = 'queue';

    public function __construct(private ConsumerInterface $consumer)
    {
        parent::__construct();
    }

    /**
     * @param mixed[] $config
     */
    public function setConfig($config): void
    {
        $this->config = $config;
    }

    protected function configure(): void
    {
        if(null !== self::$defaultName) {
            $this->setName(self::$defaultName);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->config['queues'] as $name => $queue) {
            $this->consumer->read($name, $queue);
        }

        return 0;
    }
}
