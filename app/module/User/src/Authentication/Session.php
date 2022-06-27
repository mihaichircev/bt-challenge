<?php

namespace User\Authentication;

use Laminas\Session\Container;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Storage\StorageInterface;

class Session
{
    protected Container $session;

    public function __construct()
    {
        $this->session = new Container('authentication', Container::getDefaultManager());
        $this->session->getManager()->setStorage(new SessionArrayStorage());
    }

    /**
     * @return StorageInterface<mixed>
     */
    public function getStorage(): StorageInterface
    {
        return $this->session->getManager()->getStorage();
    }

    public function setIdentity(int $value): void
    {
        $this->getStorage()->identity = $value; // @phpstan-ignore-line
    }

    public function getIdentity(): int
    {
        return $this->getStorage()->identity; // @phpstan-ignore-line
    }

    public function clearIdentity(): void
    {
        $this->getStorage()->clear('identity');
    }

    public function hasIdentity(): bool
    {
        return null !== $this->getStorage()->identity; // @phpstan-ignore-line
    }

    public function setRequesterId(int $requesterId): void
    {
        $this->getStorage()->requesterId = $requesterId; // @phpstan-ignore-line
    }

    public function getRequesterId(): int
    {
        return $this->getStorage()->requesterId; // @phpstan-ignore-line
    }

    public function hasRequesterId(): bool
    {
        return null !== $this->getStorage()->requesterId; // @phpstan-ignore-line
    }

    public function clearRequesterId(): void
    {
        $this->getStorage()->clear('requesterId');
    }
}
