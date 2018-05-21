<?php

namespace App\Controller;

use App\Commands\PageCommand;
use App\Repository\Page\PageInterface;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 * @package App\Controller
 */
class PageController
{
    /**
     * @var CommandBus
     */
    private $bus;

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
     * @param CommandBus         $bus
     * @param PageInterface      $page
     * @param AbstractController $controller
     */
    public function __construct(CommandBus $bus, PageInterface $page, AbstractController $controller)
    {
        $this->bus        = $bus;
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
            return $this->controller->errorJson('page.not.found', 404);
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
            return $this->controller->errorJson('page.not.found', 404);
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

    /**
     * @param string $pageId
     *
     * @return JsonResponse
     */
    public function getPageBy(string $pageId): JsonResponse
    {
        $page = $this->pageRepo->getById($pageId);
        if (empty($page)) {
            return $this->controller->errorJson('page.not.found', 404);
        }
        return $this->controller->json($page);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function savePage(Request $request): JsonResponse
    {
        $pageId       = $request->request->get('pageId');
        $title        = $request->request->get('title');
        $content      = $request->request->get('content');
        $slug         = $request->request->get('slug');
        $parentPageId = $request->request->get('parentPageId');
        $isDefault    = $request->request->getBoolean('isDefault');

        $this->bus->handle(new PageCommand($pageId, $title, $content, $slug, $parentPageId, $isDefault));

        return $this->controller->acceptJson('page.saved:');
    }
}