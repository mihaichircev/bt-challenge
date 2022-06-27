<?php

declare(strict_types=1);

namespace CommonTest\Override;

use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

/**
 * @mixin TestCase
 */
trait ProphecyTrait
{
    /**
     * @var Prophet|null
     *
     * @internal
     */
    private $prophet;

    protected function prophesize(?string $classOrInterface = null): ObjectProphecy
    {
        return $this->getProphet()->prophesize($classOrInterface);
    }

    /**
     * @internal
     */
    private function getProphet(): Prophet
    {
        if ($this->prophet === null) {
            $this->prophet = new Prophet();
        }

        return $this->prophet;
    }
}
