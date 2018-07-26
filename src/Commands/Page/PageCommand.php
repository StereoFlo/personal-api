<?php

namespace Commands\Page;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PageCommand
 * @package Commands
 */
class PageCommand
{
    /**
     * @var null|string
     */
    private $pageId;

    /**
     * @var string|null
     */
    private $parentPageId;

    /**
     * @var string
     */
    private $title;

    /**
     * @Assert\NotBlank(message="the content cannot be empty")
     *
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var bool
     */
    private $isDefault = false;

    /**
     * PageCommand constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->init($request);
    }

    /**
     * @return null|string
     */
    public function getPageId(): ?string
    {
        return $this->pageId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return bool
     */
    public function getIsDefault(): bool
    {
        return $this->isDefault;
    }

    /**
     * @return null|string
     */
    public function getParentPageId(): ?string
    {
        return $this->parentPageId;
    }

    /**
     * @param Request $request
     *
     * @return PageCommand
     */
    private function init(Request $request): self
    {
        foreach ($request->request->all() as $key => $val) {
            if (\property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
        return $this;
    }
}