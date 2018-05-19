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
     * @var AbstractController
     */
    private $controller;

    /**
     * DefaultController constructor.
     *
     * @param AbstractController $abstractController
     */
    public function __construct(AbstractController $abstractController)
    {
        $this->controller = $abstractController;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->controller->errorJson('page.not.found', 404);
    }
}