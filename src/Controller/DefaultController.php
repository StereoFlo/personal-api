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

    /**
     * @return JsonResponse
     */
    public function admin()
    {
        return JsonResponse::create(['success' => true, 'message' => 'you are admin']);
    }
}