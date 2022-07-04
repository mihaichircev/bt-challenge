<?php

namespace UserTest\Entity;

use CommonTest\Override\ProphecyTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\TestCase;
use User\Entity\User;

class UserTest extends TestCase
{
    use ProphecyTrait;

    public function testCredentialsCheckTrue(): void
    {
        $user = new User();
        $user->setPassword(password_hash('foobar', PASSWORD_BCRYPT));
        $this->assertSame(true, $user->credentialsCheck('foobar'));
    }

    public function isOtpLimitReachedFalse(): void
    {
        $arrayCollectionMock = $this->prophesize(ArrayCollection::class);

        $userMock = $this->prophesize(User::class);
        $userMock->getOtps()
            ->shouldBeCalled()
            ->willReturn($arrayCollectionMock);

        $criteriaMock = $this->prophesize(Criteria::class);

        $arrayCollectionMock->matching($criteriaMock)
            ->shouldBeCalled()
            ->willReturn($arrayCollectionMock);

        $arrayCollectionMock->count()
            ->shouldBeCalled()
            ->willReturn(3);

        $user = new User();

        $this->assertFalse($user->isOtpLimitReached());
    }

    public function isOtpLimitReachedTrue(): void
    {
        $arrayCollectionMock = $this->prophesize(ArrayCollection::class);

        $userMock = $this->prophesize(User::class);
        $userMock->getOtps()
            ->shouldBeCalled()
            ->willReturn($arrayCollectionMock);

        $criteriaMock = $this->prophesize(Criteria::class);

        $arrayCollectionMock->matching($criteriaMock)
            ->shouldBeCalled()
            ->willReturn($arrayCollectionMock);

        $arrayCollectionMock->count()
            ->shouldBeCalled()
            ->willReturn(5);

        $user = new User();

        $this->assertTrue($user->isOtpLimitReached());
    }
}
