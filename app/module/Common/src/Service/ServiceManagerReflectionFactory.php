<?php

namespace Common\Service;

use Interop\Container\ContainerInterface;
use ReflectionClass;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\ServiceManager;

class ServiceManagerReflectionFactory implements FactoryInterface
{
    /**
     * @param mixed $requestedName
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $args = [];
        $reflection = new ReflectionClass($requestedName);
        if ($reflection->getConstructor() !== null) {
            foreach ($reflection->getConstructor()->getParameters() as $param) {
                if (null !== $param->getType()) {
                    switch ($param->getType()->getName()) { // @phpstan-ignore-line
                        case ServiceManager::class:
                            $args[] = $container->get('ServiceManager');
                            break;
                        default:
                            $args[] = $container->get($param->getType()->getName()); // @phpstan-ignore-line
                    }
                }
            }
        }

        return $reflection->newInstanceArgs($args);
    }
}
