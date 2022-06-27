<?php

namespace UserTest\View\Helper;

use CommonTest\Override\ProphecyTrait;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use User\Authentication\Service\AuthenticationService;
use User\Authentication\Session;
use User\Service\UserService;
use User\View\Helper\AuthenticationHelper;

/**
 * @covers \User\View\Helper\AuthenticationHelper
 */
class AuthenticationHelperTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $userServiceMock;
    private ObjectProphecy $sessionMock;
    private EntityManager $entityManager;

    public function setUp(): void
    {
        $this->entityManager = $this->prophesize(EntityManager::class)->reveal();
        $this->userServiceMock = $this->prophesize(UserService::class)->willBeConstructedWith([$this->entityManager]);
        $this->sessionMock = $this->prophesize(Session::class)->willBeConstructedWith();
    }

    public function testInvokeReturnsAuthenticationService(): void
    {
        $authenticationService = $this->prophesize(AuthenticationService::class)
            ->willBeConstructedWith([$this->sessionMock->reveal(), $this->userServiceMock->reveal()])
            ->reveal();
        $helper = new AuthenticationHelper($authenticationService);

        $this->assertSame($authenticationService, $helper());
    }
}
