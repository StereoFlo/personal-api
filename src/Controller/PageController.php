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
     * PageController constructor.
     *
     * @param PageInterface $page
     */
    public function __construct(PageInterface $page)
    {
        $this->pageRepo = $page;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $defaultPage = $this->pageRepo->getDefaultPage();
        if (empty($defaultPage)) {
            return JsonResponse::create(['success' => true, 'data' => $defaultPage]);
        }
        return JsonResponse::create(['success' => false, 'message' => 'page does not found'], 404);
    }

    /**
     * @param string $slug
     *
     * @return JsonResponse
     */
    public function getPage(string $slug): JsonResponse
    {
        $page = $this->pageRepo->getBySlug($slug);
        if (empty($page)) {
            return JsonResponse::create(['success' => true, 'data' => $page]);
        }
        return JsonResponse::create(['success' => false, 'message' => 'page does not found'], 404);
    }
}