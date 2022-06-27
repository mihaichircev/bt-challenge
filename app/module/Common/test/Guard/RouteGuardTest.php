<?php

namespace CommonTest\Controller;

use Common\Guard\RouteGuard;
use Common\Service\AuthorizationService;
use CommonTest\Override\ProphecyTrait;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\Application;
use Laminas\Mvc\MvcEvent;
use Laminas\Router\RouteMatch;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Common\Guard\RouteGuard
 */
class RouteGuardTest extends TestCase
{
    use ProphecyTrait;

    private AuthorizationService $authorizationService;

    public function testUnauthorizedRoute()
    {
        $authorizationServiceMock = $this->prophesize(AuthorizationService::class);
        $routeMatchMock = $this->prophesize(RouteMatch::class);
        $eventMock = $this->prophesize(MvcEvent::class);
        $eventMock->getRouteMatch()
            ->shouldBeCalled()
            ->willReturn($routeMatchMock->reveal());

        $routeMatchMock->getMatchedRouteName()
            ->shouldBeCalled()
            ->willReturn('logout');

        $authorizationServiceMock->isAllowed('logout')
            ->shouldBeCalled()
            ->willReturn(false);

        $targetMock = $this->prophesize(Application::class);
        $eventMock->getTarget()
            ->shouldBeCalled()
            ->willReturn($targetMock->reveal());
        $eventManagerInterfaceMock = $this->prophesize(EventManagerInterface::class);
        $targetMock->getEventManager()
            ->shouldBeCalled()
            ->willReturn($eventManagerInterfaceMock->reveal());
        $eventManagerInterfaceMock->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $eventMock->reveal())
            ->shouldBeCalled();

        $routeGuard = new RouteGuard($authorizationServiceMock->reveal());

        $this->assertFalse($routeGuard->onRoute($eventMock->reveal()));
    }

    public function testAuthorizedRoute()
    {
        $authorizationServiceMock = $this->prophesize(AuthorizationService::class);
        $routeMatchMock = $this->prophesize(RouteMatch::class);
        $eventMock = $this->prophesize(MvcEvent::class);
        $eventMock->getRouteMatch()
            ->shouldBeCalled()
            ->willReturn($routeMatchMock->reveal());

        $routeMatchMock->getMatchedRouteName()
            ->shouldBeCalled()
            ->willReturn('home');

        $authorizationServiceMock->isAllowed('home')
            ->shouldBeCalled()
            ->willReturn(true);

        $routeGuard = new RouteGuard($authorizationServiceMock->reveal());

        $this->assertTrue($routeGuard->onRoute($eventMock->reveal()));
    }
}
