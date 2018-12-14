<?php

namespace Domain\User\Handlers;

use Domain\Commands\User\UserRegisterCommand;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepository;

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
     *
     * @throws \Exception
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