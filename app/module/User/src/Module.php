<?php

namespace User;

use Doctrine\ORM\Events;
use Laminas\Mvc\MvcEvent;
use User\Listener\OtpListener;

class Module
{
    /**
     * @return Array<mixed>
     */
    public function getConfig(): array
    {
        $config = [];
        $configs = glob(__DIR__ . '/../config/*.config.php');

        if (false !== $configs) {
            foreach ($configs as $file) {
                $config = array_merge($config, include $file);
            }
        }

        return $config;
    }

    public function onBootstrap(MvcEvent $e): void
    {
        $sm = $e->getApplication()->getServiceManager();
        $doctrineEventManager = $sm->get('doctrine.entitymanager.orm_default')->getEventManager();
        $doctrineEventManager->addEventListener([Events::prePersist, Events::postFlush], $sm->get(OtpListener::class));
    }
}
