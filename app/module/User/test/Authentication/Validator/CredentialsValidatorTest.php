<?php

namespace UserTest\Authentication\Validator;

use Common\Exception\NotFoundException;
use CommonTest\Override\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use User\Authentication\Validator\CredentialsValidator;
use User\Authentication\Result;
use User\Authentication\Session;
use User\Entity\User;
use User\Service\OtpService;
use User\Service\UserService;

class CredentialsValidatorTest extends TestCase
{
    use ProphecyTrait;

    private $userServiceMock;
    private $sessionMock;

    public function setUp(): void
    {
        $this->userServiceMock = $this->prophesize(UserService::class);
        $this->sessionMock = $this->prophesize(Session::class);
    }

    public function testValidateInvalidUsername()
    {
        $this->userServiceMock->loadByUsername('foo')
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('Not found'));

        $adapter = new CredentialsValidator(
            $this->userServiceMock->reveal(),
            $this->sessionMock->reveal()
        );
        $result = $adapter->validate(['username' => 'foo', 'password' => 'bar']);

        $this->assertSame(false, $result->isValid());
        $this->assertSame(Result::CODE_INVALID_CREDENTIALS, $result->getCode());
    }

    public function testValidateInvalidPassword()
    {
        $userMock = $this->prophesize(User::class);
        $this->userServiceMock->loadByUsername('foo')
            ->shouldBeCalled()
            ->willReturn($userMock);

        $userMock->credentialsCheck('bar')
            ->shouldBeCalled()
            ->willReturn(false);

        $adapter = new CredentialsValidator(
            $this->userServiceMock->reveal(),
            $this->sessionMock->reveal()
        );
        $result = $adapter->validate(['username' => 'foo', 'password' => 'bar']);

        $this->assertSame(false, $result->isValid());
        $this->assertSame(Result::CODE_INVALID_CREDENTIALS, $result->getCode());
    }

    public function testValidateUserPassword()
    {
        $userMock = $this->prophesize(User::class);
        $this->userServiceMock->loadByUsername('foo')
            ->shouldBeCalled()
            ->willReturn($userMock);

        $userMock->credentialsCheck('bar')
            ->shouldBeCalled()
            ->willReturn(true);

        $userMock->getId()
            ->shouldBeCalled()
            ->willReturn(1);

        $resultMock = $this->prophesize(Result::class);
        $resultMock->success(1)
            ->shouldBeCalled()
            ->willReturn($resultMock);

        $adapter = new CredentialsValidator(
            $this->userServiceMock->reveal(),
            $this->sessionMock->reveal()
        );
        $result = $adapter->validate(['username' => 'foo', 'password' => 'bar']);

        $this->assertSame(true, $result->isValid());
    }
}
