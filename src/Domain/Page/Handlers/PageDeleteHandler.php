<?php

namespace Handlers\Page;

use Domain\Page\Commands\PageDeleteCommand;
use Domain\Page\Repository\PageReadInterface;
use Domain\Page\Repository\PageWriteInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PageDeleteHandler
 * @package Handlers\Page
 */
class PageDeleteHandler
{

    /**
     * @var PageReadInterface
     */
    private $pageRead;

    /**
     * @var PageWriteInterface
     */
    private $pageWrite;

    /**
     * PageDeleteHandler constructor.
     *
     * @param PageReadInterface  $pageRead
     * @param PageWriteInterface $pageWrite
     */
    public function __construct(PageReadInterface $pageRead, PageWriteInterface $pageWrite)
    {
        $this->pageRead  = $pageRead;
        $this->pageWrite = $pageWrite;
    }

    /**
     * @param PageDeleteCommand $command
     */
    public function handle(PageDeleteCommand $command): void
    {
        if (!Uuid::isValid($command->getPageId())) {
            throw new NotFoundHttpException('page.not.found');
        }

        $page = $this->pageRead->getById($command->getPageId());
        if (empty($page)) {
            throw new NotFoundHttpException('page.not.found');
        }
        $this->pageWrite->delete($page);
    }
}