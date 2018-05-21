<?php

namespace App\Handlers;

use App\Commands\PageCommand;
use App\Entity\Page;
use App\Repository\Page\PageInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PageHandler
 * @package App\Handlers
 */
class PageHandler
{
    /**
     * @var PageInterface
     */
    private $pageRepo;

    /**
     * PageHandler constructor.
     *
     * @param PageInterface $page
     */
    public function __construct(PageInterface $page)
    {
        $this->pageRepo = $page;
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
                $parentPage = $this->pageRepo->getById($command->getParentPageId());
                if (empty($parentPage)) {
                    throw new NotFoundHttpException('parent page does not found'); //todo use translation
                }
                $page->setParentPageId($parentPage);
            }
            $page->setUpdatedAt()
                ->setCreatedAt();
            $this->pageRepo->save($page);
            return;
        }

        $page = $this->pageRepo->getById($command->getPageId());
        if (empty($page)) {
            throw new NotFoundHttpException('page.not.found');
        }

        if ($command->getParentPageId()) {
            $parentPage = $this->pageRepo->getById($command->getParentPageId());
            if (empty($parentPage)) {
                throw new NotFoundHttpException('parent page does not found'); //todo use translation
            }
            $page->setParentPageId($parentPage);
        }

        $page->setTitle($command->getTitle())
            ->setContent($command->getContent())
            ->setSlug($command->getSlug())
            ->setUpdatedAt();
        $this->pageRepo->save($page);
    }

    /**
     * @return Page
     */
    private function getPage(): Page
    {
        return new Page();
    }
}