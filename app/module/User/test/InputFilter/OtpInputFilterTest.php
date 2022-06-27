<?php

namespace UserTest\InputFilter;

use PHPUnit\Framework\TestCase;
use User\InputFilter\OtpInputFilter;

/**
 * @covers \User\InputFilter\OtpInputFilter
 */
class OtpInputFilterTest extends TestCase
{
    public function testInputFiltersAreSetCorrectly(): void
    {
        $inputFilter = new OtpInputFilter();

        $this->assertSame(1, $inputFilter->count());
        $this->assertTrue($inputFilter->has('token'));
    }
}
