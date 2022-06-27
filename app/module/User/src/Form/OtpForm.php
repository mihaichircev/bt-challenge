<?php

namespace User\Form;

use Laminas\Form\Form;

class OtpForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setAttribute('class', 'form');
        $this->setAttribute('action', '/otp');

        $this->add(
            [
            'name' => 'token',
            'type' => 'text',
            'required' => true,
            'options' => [
                'label' => 'Token',
            ],
            'attributes' => [
                'class' => 'form-control form-control-sm',
                'placeholder' => 'Enter the token'
            ]
            ]
        );
    }
}
