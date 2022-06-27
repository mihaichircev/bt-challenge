<?php

declare(strict_types=1);

namespace User\Service;

use Common\Exception\NotFoundException;
use DateTime;
use Doctrine\ORM\EntityManager;
use User\Entity\Otp;
use User\Entity\User;

class OtpService
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function loadById(int $id): Otp
    {
        $otp = $this->entityManager->getRepository(Otp::class)->findOneBy(['id' => $id]);

        if (null === $otp) {
            throw new NotFoundException('Otp not found with id: ' . $id);
        }

        return $otp;
    }

    public function generateOtp(int $userId): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
        if (null === $user) {
            throw new NotFoundException('OTP creation failed. User not found: ' . $userId);
        }

        $otp = new Otp();
        $otp->setUser($user);
        $otp->setCreatedAt(new DateTime());
        $otp->setToken(random_int(100000, 999999));

        $this->entityManager->persist($otp);
        $this->entityManager->flush();
    }

    public function remove(Otp $otp): void
    {
        $this->entityManager->remove($otp);
        $this->entityManager->flush();
    }
}
