<?php

namespace User\InputFilter;

use Common\InputFilter\IntegerInputFilter;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;

class OtpInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'token',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
                new IntegerInputFilter()
            ]
        ]);
    }
}
