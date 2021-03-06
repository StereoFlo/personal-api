<?php

namespace Domain\Page\Handlers;

use Domain\Page\Commands\PageCommand;
use Domain\Page\Entity\Page;
use Domain\Page\Repository\PageReadInterface;
use Domain\Page\Repository\PageWriteInterface;
use HttpInvalidParamException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PageHandler
 * @package Handlers
 */
class PageHandler
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
     * PageHandler constructor.
     *
     * @param PageReadInterface  $pageRead
     * @param PageWriteInterface $pageWrite
     */
    public function __construct(PageReadInterface $pageRead, PageWriteInterface $pageWrite)
    {
        $this->pageWrite = $pageWrite;
        $this->pageRead  = $pageRead;
    }

    /**
     * @param PageCommand $command
     *
     * @throws \Exception
     */
    public function handle(PageCommand $command)
    {
        $page = $this->getPage($command->getPageId())
            ->setTitle($command->getTitle())
            ->setContent($command->getContent())
            ->setSlug($command->getSlug())
            ->setIsDefault($command->getIsDefault())
            ->setShowInMenu($command->getShowInMenu());

        $this->checkPreviousDefaultPage($command);

        if ($command->getParentPageId()) {
            $parentPage = $this->pageRead->getById($command->getParentPageId());
            if (empty($parentPage)) {
                throw new NotFoundHttpException('parent page does not found'); //todo use translation
            }
            $page->setParentPageId($parentPage);
        }
        $page->setUpdatedAt()
            ->setCreatedAt();
        $this->pageWrite->save($page);
    }

    /**
     * @param null|string $pageId
     *
     * @return Page
     * @throws \Exception
     */
    private function getPage(?string $pageId): Page
    {
        if (isset($pageId)) {
            $page = $this->pageRead->getById($pageId);
            if (empty($page)) {
                throw new NotFoundHttpException('page.not.found');
            }
        }
        return new Page();
    }

    /**
     * @param PageCommand $command
     *
     * @throws HttpInvalidParamException
     */
    private function checkPreviousDefaultPage(PageCommand $command): void
    {
        $page = $this->pageRead->getDefaultPage();
        if (!$command->getIsDefault()) {
            if (empty($page)) {
                throw new HttpInvalidParamException('you cannot unchecdefault pagek');
            }
            $page->setIsDefault(false);
            $this->pageWrite->save($page);
        }
    }
}