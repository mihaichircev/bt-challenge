<?php

namespace User\Command;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use User\Service\UserService;

final class CreateUserCommand extends Command
{
    /**
     * @var string 
     */
    protected static $defaultName = 'create-user';

    public function __construct(
        private UserService $userService
    ) {
        parent::__construct();
    }

    protected function configure() : void
    {
        $this->setName(self::$defaultName);
        $this->addArgument('username', InputArgument::REQUIRED, 'Username');
        $this->addArgument('password', InputArgument::REQUIRED, 'Password');
        $this->addArgument('email', InputArgument::REQUIRED, 'Email');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $email = $input->getArgument('email');

        $this->userService->create($username, $password, $email);
        
        return 0;
    }
}
