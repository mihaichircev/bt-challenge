<?php

namespace UserTest\InputFilter;

use PHPUnit\Framework\TestCase;
use User\InputFilter\LoginInputFilter;

/**
 * @covers \User\InputFilter\LoginInputFilter
 */
class LoginInputFilterTest extends TestCase
{
    public function testInputFiltersAreSetCorrectly(): void
    {
        $inputFilter = new LoginInputFilter();

        $this->assertSame(2, $inputFilter->count());
        $this->assertTrue($inputFilter->has('username'));
        $this->assertTrue($inputFilter->has('password'));
    }
}
