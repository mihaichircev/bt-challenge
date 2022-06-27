<?php

namespace Common\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class MemcachedServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $memcached = new \Memcached();
        $config = $container->get('config');

        if (isset($config['memcached'])) {
            $memcached->addServer($config['memcached']['host'], $config['memcached']['port']);
        } else {
            $memcached->addServer('localhost', 11211);
        }
        return $memcached;
    }
}
