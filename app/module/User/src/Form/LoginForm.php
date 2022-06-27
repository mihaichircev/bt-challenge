<?php

namespace User\Form;

use Laminas\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setAttribute('class', 'form');
        $this->setAttribute('action', '/login');

        $this->add(
            [
            'name' => 'username',
            'type' => 'text',
            'required' => true,
            'options' => [
               'label' => 'Username',
            ],
            'attributes' => [
               'class' => 'form-control form-control-sm',
               'placeholder' => 'Enter your username'
            ]
            ]
        );

        $this->add(
            [
            'name' => 'password',
            'type' => 'password',
            'required' => true,
            'options' => [
               'label' => 'Password',
            ],
            'attributes' => [
               'class' => 'form-control form-control-sm',
               'placeholder' => 'Enter your password',
            ],
            ]
        );
    }
}
