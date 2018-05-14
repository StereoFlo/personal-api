<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'message' => 'page does not found'
        ], 404);
    }
    /**
     * @return JsonResponse
     */
    public function admin(): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'message' => 'admin'
        ], 200);
    }
}