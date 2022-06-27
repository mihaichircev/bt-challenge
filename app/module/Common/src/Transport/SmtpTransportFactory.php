<?php

namespace Common\Transport;

use Interop\Container\ContainerInterface;
use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SmtpTransportFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new Smtp();
        $config = $container->get('config')['mail']['transport']['smtp'];
        $options = new SmtpOptions(
            [
            'name' => $config['from_name'],
            'host' => $config['server'],
            'port' => $config['port'],
            'connection_class' => $config['connection_class'],
            'connection_config' => [
                'username' => $config['smtp_user'],
                'password' => $config['smtp_password'],
                'ssl' => $config['ssl']
            ]
            ]
        );
        $service->setOptions($options);

        return $service;
    }
}
