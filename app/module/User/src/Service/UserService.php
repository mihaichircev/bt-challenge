<?php

declare(strict_types=1);

namespace User\Service;

use Common\Exception\NotFoundException;
use Doctrine\ORM\EntityManager;
use User\Entity\User;

class UserService
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function create($username, $password, $email): void
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        $user->setEmail($email);
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function loadById(int $id): User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        if (null === $user) {
            throw new NotFoundException('User not found with id: ' . $id);
        }

        return $user;
    }

    public function loadByUsername(string $username): User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if (null === $user) {
            throw new NotFoundException('User not found with username: ' . $username);
        }

        return $user;
    }
}
