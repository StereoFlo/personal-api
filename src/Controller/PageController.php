<?php

namespace App\Controller;

use App\Repository\Page\PageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PageController
 * @package App\Controller
 */
class PageController
{
    /**
     * @var PageInterface
     */
    private $pageRepo;

    /**
     * @var AbstractController
     */
    private $controller;

    /**
     * PageController constructor.
     *
     * @param PageInterface      $page
     * @param AbstractController $controller
     */
    public function __construct(PageInterface $page, AbstractController $controller)
    {
        $this->pageRepo   = $page;
        $this->controller = $controller;
    }

    /**
     * @return JsonResponse
     */
    public function getDefault(): JsonResponse
    {
        $defaultPage = $this->pageRepo->getDefaultPage();
        if (empty($defaultPage)) {
            return $this->controller->errorJson('page does not found', 404);
        }

        return $this->controller->json($defaultPage);
    }

    /**
     * @param string $slug
     *
     * @return JsonResponse
     */
    public function getBy(string $slug): JsonResponse
    {
        $page = $this->pageRepo->getBySlug($slug);
        if (empty($page)) {
            return $this->controller->errorJson('page does not found', 404);
        }
        return $this->controller->json($page);
    }

    /**
     * @return JsonResponse
     */
    public function getList(): JsonResponse
    {
        $list = $this->pageRepo->getList();
        return $this->controller->json($list);
    }
}