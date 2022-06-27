<?php

namespace User\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Queue\Producer\ProducerInterface;
use User\Entity\Otp;

class OtpListener
{
    private ?Otp $otp = null;

    public function __construct(private ProducerInterface $producer, private string $queue)
    {
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if ($entity instanceof Otp) {
            $this->otp = $entity;
        }
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        if (null !== $this->otp) {
            $this->producer->send($this->otp->getId(), $this->queue);
            $this->otp = null;
        }
    }
}
