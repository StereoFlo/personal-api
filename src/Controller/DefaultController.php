<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class IndexController
 * @package App\Controller
 */
class DefaultController
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return JsonResponse::create(['success' => true]);
    }
}