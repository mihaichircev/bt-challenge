<?php

declare(strict_types=1);

namespace User\Entity;

use DateInterval;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users_otp")
 */
class Otp
{
    private const OTP_EXPIRE = 'PT120S';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="otps")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected User $user;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $token;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected DateTime $createdAt;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): Otp
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Otp
    {
        $this->user = $user;

        return $this;
    }

    public function getToken(): int
    {
        return $this->token;
    }

    public function setToken(int $token): Otp
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Otp
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isValid(): bool
    {
        $now = new DateTime();
        $now->sub(new DateInterval(self::OTP_EXPIRE));

        return $now < $this->getCreatedAt();
    }
}
