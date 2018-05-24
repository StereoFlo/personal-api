<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\User\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController
{
    /**
     * @var User|null
     */
    private $user;

    /**
     * @var UserInterface
     */
    private $userRepo;

    /**
     * @var AbstractController
     */
    private $controller;

    /**
     * UserController constructor.
     *
     * @param User|null          $user
     * @param UserInterface      $userRepo
     * @param AbstractController $controller
     */
    public function __construct(?User $user, UserInterface $userRepo, AbstractController $controller)
    {
        $this->user       = $user;
        $this->userRepo   = $userRepo;
        $this->controller = $controller;
    }

    /**
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        if (empty($this->controller->getCurrentUser())) {
            return $this->controller->errorJson('user.empty', 401);
        }
        return $this->controller->json($this->controller->getCurrentUser(), 'user-public');
    }
}