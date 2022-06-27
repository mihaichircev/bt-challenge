<?php

declare(strict_types=1);

namespace User\Controller;

use Laminas\Http\Response;
use User\Form\LoginForm;
use User\InputFilter\LoginInputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Authentication\Result;
use User\Authentication\Service\AuthenticationService;
use User\Form\OtpForm;
use User\InputFilter\OtpInputFilter;

class AuthController extends AbstractActionController
{
    public function __construct(private AuthenticationService $authService)
    {
    }

    public function loginAction(): Response|ViewModel
    {
        $form = new LoginForm();
        if ($this->getRequest()->isPost()) { // @phpstan-ignore-line
            $form->setInputFilter(new LoginInputFilter());
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $data = $form->getData();

                $result = $this->authService->validate(AuthenticationService::CHECK_CREDENTIALS, $data);
                if ($result->isValid()) {
                    $result = $this->authService->validate(AuthenticationService::CHECK_OTP_LIMIT);
                    if ($result->isValid()) {
                        return $this->redirect()->toRoute('otp');
                    }
                }

                $this->flashMessenger()->addMessage($result->getMessage(), 'error'); // @phpstan-ignore-line
            }
        }

        return new ViewModel([ 'form' => $form ]);
    }

    public function otpAction(): Response|ViewModel
    {
        $form = new OtpForm();

        if ($this->params()->fromQuery('resend')) {
            $result = $this->authService->validate(AuthenticationService::CHECK_OTP_LIMIT);
            if (! $result->isValid()) {
                if ($result->getCode() === Result::CODE_USER_INVALID) {
                    return $this->redirect()->toRoute('login');
                } else {
                    $this->flashMessenger()->addMessage($result->getMessage(), 'error'); // @phpstan-ignore-line
                }
            }
        } else {
            if ($this->getRequest()->isPost()) { // @phpstan-ignore-line
                $form->setInputFilter(new OtpInputFilter());
                $form->setData($this->params()->fromPost());
                if ($form->isValid()) {
                    /**
                     * @var Array<mixed> $data
                     */
                    $data = $form->getData();
                    $result = $this->authService->validate(AuthenticationService::CHECK_OTP, $data['token']);
                    if ($result->isValid()) {
                        return $this->redirect()->toRoute('home');
                    } else {
                        $this->flashMessenger()->addMessage($result->getMessage(), 'error'); // @phpstan-ignore-line
                    }
                }
            }
        }

        return new ViewModel([ 'form' => $form ]);
    }

    public function logoutAction(): Response
    {
        $this->authService->clearIdentity();
        return $this->redirect()->toRoute('home');
    }
}
