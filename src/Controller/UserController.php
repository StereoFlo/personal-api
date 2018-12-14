<?php

namespace Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 * @package Controller
 */
class UserController extends AbstractController
{
    /**
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        if (empty($this->getCurrentUser())) {
            return $this->errorJson('user.empty', 401);
        }
        return $this->json($this->getCurrentUser(), 'user-public');
    }
}