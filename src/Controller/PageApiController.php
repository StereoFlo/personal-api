<?php

namespace Controller;

use Domain\Page\Commands\PageCommand;
use Domain\Page\Commands\PageDeleteCommand;
use Domain\Page\Repository\PageReadInterface;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PageApiController
 * @package Controller
 */
class PageApiController extends AbstractApiController
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
     * PageApiController constructor.
     *
     * @param CommandBus         $bus
     * @param PageReadInterface  $page
     */
    public function __construct(CommandBus $bus, PageReadInterface $page)
    {
        $this->bus        = $bus;
        $this->pageRepo   = $page;
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
        return $this->json($defaultPage, 'page-list');
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
        return $this->json($page, 'page-list');
    }

    /**
     * @return JsonResponse
     */
    public function getList(): JsonResponse
    {
        $list = $this->pageRepo->getList();
        $total = $this->pageRepo->getCountForList();

        return $this->dataJson($total, $list, 'page-list');
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
        return $this->json($page, 'page-list');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function savePage(Request $request): JsonResponse
    {
        $this->bus->handle(new PageCommand($request));

        return $this->acceptJson('page.saved');
    }

    /**
     * @param string $pageId
     *
     * @return JsonResponse
     */
    public function deletePage(string $pageId): JsonResponse
    {
        $this->bus->handle(new PageDeleteCommand($pageId));
        return $this->acceptJson('page.deleted');
    }
}