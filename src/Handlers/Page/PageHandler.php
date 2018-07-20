<?php

namespace App\Handlers\Page;

use App\Commands\Page\PageCommand;
use App\Entity\Page;
use App\Repository\Page\PageReadInterface;
use App\Repository\Page\PageWriteInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PageHandler
 * @package App\Handlers
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
     * @todo need a refactor
     * @param PageCommand $command
     */
    public function handle(PageCommand $command)
    {
        if (empty($command->getPageId())) {
            $page = $this->getPage()
                ->setTitle($command->getTitle())
                ->setContent($command->getContent())
                ->setSlug($command->getSlug());
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
            return;
        }

        $page = $this->pageRead->getById($command->getPageId());
        if (empty($page)) {
            throw new NotFoundHttpException('page.not.found');
        }

        if ($command->getParentPageId()) {
            $parentPage = $this->pageRead->getById($command->getParentPageId());
            if (empty($parentPage)) {
                throw new NotFoundHttpException('parent page does not found'); //todo use translation
            }
            $page->setParentPageId($parentPage);
        }

        $page->setTitle($command->getTitle())
            ->setContent($command->getContent())
            ->setSlug($command->getSlug())
            ->setUpdatedAt();
        $this->pageWrite->save($page);
    }

    /**
     * @return Page
     */
    private function getPage(): Page
    {
        return new Page();
    }
}