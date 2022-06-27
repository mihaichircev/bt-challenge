<?php

namespace Queue\Handler;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Service\OtpService;

class OtpHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $senderCLass = $container->get('config')['authentication']['otp']['sender'];

        return new OtpHandler(
            $container->get($senderCLass),
            $container->get(OtpService::class)
        );
    }
}
