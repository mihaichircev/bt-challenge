<?php

namespace CommonTest\Controller;

use Common\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * @covers Common\Controller\IndexController
 */
class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp(): void
    {
        $configOverrides = [];

        $this->setApplicationConfig(
            ArrayUtils::merge(
            // Grabbing the full application configuration:
                include __DIR__ . '/../../../../config/application.config.php',
                $configOverrides
            )
        );
        parent::setUp();
    }

    public function testIndexAction()
    {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Common');
        $this->assertControllerName(IndexController::class);
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }
}
