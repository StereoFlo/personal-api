<?php

namespace App\Controller;

use App\Commands\Page\PageDeleteCommand;
use App\Commands\Page\PageCommand;
use App\Repository\Page\PageReadInterface;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            throw new NotFoundHttpException('page.not.found');
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
            throw new NotFoundHttpException('page.not.found');
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
        $this->bus->handle(new PageCommand($request));

        return $this->controller->acceptJson('page.saved');
    }

    /**
     * @todo вынести в хандлер
     *
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