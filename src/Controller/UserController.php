<?php

namespace Controller;

use Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 * @package Controller
 */
class UserController
{
    /**
     * @var User|null
     */
    private $user;

    /**
     * @var AbstractController
     */
    private $controller;

    /**
     * UserController constructor.
     *
     * @param User|null          $user
     * @param AbstractController $controller
     */
    public function __construct(?User $user, AbstractController $controller)
    {
        $this->user       = $user;
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