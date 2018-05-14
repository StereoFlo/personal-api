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
     * @param PageCommand $command
     */
    public function handle(PageCommand $command)
    {
        if (empty($command->getPageId())) {
            $page = $this->getPage()
                ->setTitle($command->getTitle())
                ->setContent($command->getContent())
                ->setSlug($command->getSlug())
                ->setUpdatedAt()
                ->setCreatedAt();
            $this->pageRepo->save($page);
            return;
        }

        $page = $this->pageRepo->getById($command->getPageId());
        if (empty($page)) {
            throw new NotFoundHttpException('page does not found');
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