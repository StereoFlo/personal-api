<?php

namespace Handlers\User;

use Commands\User\UserRegisterCommand;
use Entity\User;
use Repository\User\UserRepository;

/**
 * Class UserRegister
 * @package Handlers
 */
class UserRegisterHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserRegisterHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserRegisterCommand $command
     */
    public function handle(UserRegisterCommand $command)
    {
        $password = \password_hash($command->getPassword(), PASSWORD_BCRYPT);
        $user = new User();
        $user->setEmail($command->getEmail())
            ->setUsername($command->getUsername())
            ->setPassword($password)
            ->setCreatedAt()
            ->setUpdatedAt();
        $this->userRepository->save($user);
    }
}