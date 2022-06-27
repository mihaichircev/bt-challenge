<?php

namespace UserTest\Authentication\Validator;

use Common\Exception\NotFoundException;
use CommonTest\Override\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use User\Authentication\Result;
use User\Authentication\Session;
use User\Authentication\Validator\OtpValidator;
use User\Authentication\Validator\OtpLimitValidator;
use User\Entity\Otp;
use User\Entity\User;
use User\Service\OtpService;
use User\Service\UserService;

/**
 * @covers \User\Authentication\Validator\OtpLimitValidator
 */
class OtpLimitValidatorTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $userServiceMock;
    private ObjectProphecy $otpServiceMock;

    public function setUp(): void
    {
        $this->userServiceMock = $this->prophesize(UserService::class);
        $this->otpServiceMock = $this->prophesize(OtpService::class);
        $this->sessionMock = $this->prophesize(Session::class);
    }

    public function testValidateLimitReached()
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

        $userMock->isOtpLimitReached()
            ->shouldBeCalled()
            ->willReturn(true);

        $adapter = new OtpLimitValidator(
            $this->userServiceMock->reveal(),
            $this->otpServiceMock->reveal(),
            $this->sessionMock->reveal()
        );
        $result = $adapter->validate();

        $this->assertSame(false, $result->isValid());
        $this->assertSame(Result::CODE_OTP_LIMIT_REACHED, $result->getCode());
    }
}
