<?php

namespace Common\InputFilter;

use Laminas\Filter\AbstractFilter;

class IntegerInputFilter extends AbstractFilter
{
    public function filter($value)
    {
        return $value || $value === '0' ? (int) $value : null;
    }
}
