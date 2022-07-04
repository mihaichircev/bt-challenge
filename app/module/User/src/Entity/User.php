<?php

namespace User\Entity;

use DateInterval;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    public const ROLE_GUEST = 0;
    public const ROLE_USER = 1;
    private const LIMIT_INTERVAL = 'PT30M';
    private const LIMIT_ATTEMPTS = 5;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private string $password;

    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\OneToMany(targetEntity="Otp", mappedBy="user")
     * @ORM\OrderBy({"createdAt"="DESC"})
     */
    private PersistentCollection|ArrayCollection $otps;

    public function __construct()
    {
        $this->otps = new ArrayCollection();
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getOtps(): PersistentCollection|ArrayCollection
    {
        return $this->otps;
    }

    public function setOtps(PersistentCollection|ArrayCollection $otps): User
    {
        $this->otps = $otps;

        return $this;
    }

    public function credentialsCheck(string $password): bool
    {
        return password_verify($password, $this->getPassword());
    }

    public function isOtpLimitReached(): bool
    {
        $now = new DateTime();
        $now->sub(new DateInterval(self::LIMIT_INTERVAL));

        $criteria = Criteria::create();
        $criteria->where(
            $criteria->expr()->gte('createdAt', $now)
        );

        return $this->getOtps()->matching($criteria)->count() >= self::LIMIT_ATTEMPTS;
    }
}
