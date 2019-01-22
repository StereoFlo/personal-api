<?php

namespace Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserApiController
 * @package Controller
 */
class UserApiController extends AbstractApiController
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