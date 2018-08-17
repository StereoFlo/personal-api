<?php

namespace Controller;

use Commands\Page\PageDeleteCommand;
use Commands\Page\PageCommand;
use Repository\Page\PageReadInterface;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PageController
 * @package Controller
 */
class PageController
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var PageReadInterface
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
     * @param PageReadInterface  $page
     * @param AbstractController $controller
     */
    public function __construct(CommandBus $bus, PageReadInterface $page, AbstractController $controller)
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
            throw new NotFoundHttpException('page.not.found');
        }

        return $this->controller->json($defaultPage, 'page-list');
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
            throw new NotFoundHttpException('page.not.found');
        }
        return $this->controller->json($page, 'page-list');
    }

    /**
     * @return JsonResponse
     */
    public function getList(): JsonResponse
    {
        $list = $this->pageRepo->getList();
        $total = $this->pageRepo->getCountForList();

        return $this->controller->dataJson($total, $list, 'page-list');
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
            throw new NotFoundHttpException('page.not.found');
        }
        return $this->controller->json($page, 'page-list');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function savePage(Request $request): JsonResponse
    {
        $this->bus->handle(new PageCommand($request));

        return $this->controller->acceptJson('page.saved');
    }

    /**
     * @param string $pageId
     *
     * @return JsonResponse
     */
    public function deletePage(string $pageId): JsonResponse
    {
        $this->bus->handle(new PageDeleteCommand($pageId));
        return $this->controller->acceptJson('page.deleted');
    }
}