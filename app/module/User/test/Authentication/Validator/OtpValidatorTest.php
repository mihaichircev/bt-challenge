<?php

namespace UserTest\Authentication\Validator;

use CommonTest\Override\ProphecyTrait;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use User\Authentication\Result;
use User\Authentication\Session;
use User\Authentication\Validator\OtpValidator;
use User\Entity\Otp;
use User\Entity\User;
use User\Service\OtpService;
use User\Service\UserService;

/**
 * @covers \User\Authentication\Validator\OtpValidator
 */
class OtpValidatorTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $userServiceMock;
    private ObjectProphecy $otpServiceMock;
    private ObjectProphecy $sessionMock;

    public function setUp(): void
    {
        $this->userServiceMock = $this->prophesize(UserService::class);
        $this->otpServiceMock = $this->prophesize(OtpService::class);
        $this->sessionMock = $this->prophesize(Session::class);
    }

    public function testValidateInvalidUser(): void
    {
        $this->sessionMock->hasRequesterId()
            ->shouldBeCalled()
            ->willReturn(false);

        $adapter = new OtpValidator(
            $this->userServiceMock->reveal(),
            $this->otpServiceMock->reveal(),
            $this->sessionMock->reveal()
        );
        $result = $adapter->validate(123456);

        $this->assertSame(false, $result->isValid());
        $this->assertSame(Result::CODE_USER_INVALID, $result->getCode());
    }

    public function testValidateInvalidToken(): void
    {
        $this->sessionMock->hasRequesterId()
            ->shouldBeCalled()
            ->willReturn(true);

        $this->sessionMock->getRequesterId()
            ->shouldBeCalled()
            ->willReturn(1);

        $userMock = $this->prophesize(User::class);
        $this->userServiceMock->loadById(1)
            ->shouldBeCalled()
            ->willReturn($userMock);

        $otpsMock = $this->prophesize(ArrayCollection::class);
        $userMock->getOtps()
            ->shouldBeCalled()
            ->willReturn($otpsMock);

        $otpMock = $this->prophesize(Otp::class);
        $otpsMock->first()
            ->shouldBeCalled()
            ->willReturn($otpMock);

        $otpMock->getToken()
            ->shouldBeCalled()
            ->willReturn(654321);

        $adapter = new OtpValidator(
            $this->userServiceMock->reveal(),
            $this->otpServiceMock->reveal(),
            $this->sessionMock->reveal()
        );
        $result = $adapter->validate(123456);

        $this->assertSame(false, $result->isValid());
        $this->assertSame(Result::CODE_OTP_INVALID, $result->getCode());
    }

    public function testValidateExpiredToken(): void
    {
        $this->sessionMock->hasRequesterId()
            ->shouldBeCalled()
            ->willReturn(true);

        $this->sessionMock->getRequesterId()
            ->shouldBeCalled()
            ->willReturn(1);

        $userMock = $this->prophesize(User::class);
        $this->userServiceMock->loadById(1)
            ->shouldBeCalled()
            ->willReturn($userMock);

        $otpsMock = $this->prophesize(ArrayCollection::class);
        $userMock->getOtps()
            ->shouldBeCalled()
            ->willReturn($otpsMock);

        $otpMock = $this->prophesize(Otp::class);
        $otpsMock->first()
            ->shouldBeCalled()
            ->willReturn($otpMock);

        $otpMock->getToken()
            ->shouldBeCalled()
            ->willReturn(123456);

        $otpMock->isValid()
            ->shouldBeCalled()
            ->willReturn(false);

        $adapter = new OtpValidator(
            $this->userServiceMock->reveal(),
            $this->otpServiceMock->reveal(),
            $this->sessionMock->reveal()
        );
        $result = $adapter->validate(123456);

        $this->assertSame(false, $result->isValid());
        $this->assertSame(Result::CODE_OTP_EXPIRED, $result->getCode());
    }

    public function testValidateToken(): void
    {
        $this->sessionMock->hasRequesterId()
            ->shouldBeCalled()
            ->willReturn(true);

        $this->sessionMock->getRequesterId()
            ->shouldBeCalled()
            ->willReturn(1);

        $userMock = $this->prophesize(User::class);
        $this->userServiceMock->loadById(1)
            ->shouldBeCalled()
            ->willReturn($userMock);

        $otpsMock = $this->prophesize(ArrayCollection::class);
        $userMock->getOtps()
            ->shouldBeCalled()
            ->willReturn($otpsMock);

        $otpMock = $this->prophesize(Otp::class);
        $otpsMock->first()
            ->shouldBeCalled()
            ->willReturn($otpMock);

        $otpMock->getToken()
            ->shouldBeCalled()
            ->willReturn(123456);

        $otpMock->isValid()
            ->shouldBeCalled()
            ->willReturn(true);

        $adapter = new OtpValidator(
            $this->userServiceMock->reveal(),
            $this->otpServiceMock->reveal(),
            $this->sessionMock->reveal()
        );
        $result = $adapter->validate(123456);

        $this->assertSame(true, $result->isValid());
    }
}
