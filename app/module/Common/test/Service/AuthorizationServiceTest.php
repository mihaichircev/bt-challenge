<?php

namespace CommonTest\Controller;

use Common\Service\AuthorizationService;
use CommonTest\Override\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use User\Authentication\Service\AuthenticationService;
use User\Entity\User;

/**
 * @covers \Common\Service\AuthorizationService
 */
class AuthorizationServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testConfig()
    {
        $config = [
            'roles' => [
                User::ROLE_GUEST => [
                    'parent' => null
                ],
                User::ROLE_USER => [
                    'parent' => User::ROLE_GUEST
                ],
            ],
            'routes' => [
                'home' => User::ROLE_GUEST,
                'login' => User::ROLE_GUEST,
                'otp' => User::ROLE_GUEST,
                'logout' => User::ROLE_USER,
            ]
        ];

        $authenticationServiceMock = $this->prophesize(AuthenticationService::class);
        $authorizationService = new AuthorizationService($authenticationServiceMock->reveal());
        $authorizationService->setConfig($config);

        $this->assertSame($config, $authorizationService->getConfig());
    }

    public function isGuestNotAllowed()
    {
        $config = [
            'roles' => [
                User::ROLE_GUEST => [
                    'parent' => null
                ],
                User::ROLE_USER => [
                    'parent' => User::ROLE_GUEST
                ],
            ],
            'routes' => [
                'home' => User::ROLE_GUEST,
                'login' => User::ROLE_GUEST,
                'otp' => User::ROLE_GUEST,
                'logout' => User::ROLE_USER,
            ]
        ];

        $authenticationServiceMock = $this->prophesize(AuthenticationService::class);
        $authenticationServiceMock->hasIdentity()
            ->shouldBeCalled()
            ->willReturn(false);

        $authorizationService = new AuthorizationService($authenticationServiceMock->reveal());
        $authorizationService->setConfig($config);

        $this->assertSame(false, $authorizationService->isAllowed('logout'));
    }
}
