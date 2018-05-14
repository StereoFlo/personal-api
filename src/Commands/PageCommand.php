<?php

namespace App\Commands;

/**
 * Class PageCommand
 * @package App\Commands
 */
class PageCommand
{
    /**
     * @var null|string
     */
    private $pageId;

    /**
     * @var string
     */
    private $title;

    /**
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
     * @param null|string $pageId
     * @param string      $title
     * @param string      $content
     * @param string      $slug
     * @param bool        $isDefault
     */
    public function __construct(?string $pageId, string $title, string $content, string $slug, bool $isDefault = false)
    {
        $this->pageId    = $pageId;
        $this->title     = $title;
        $this->content   = $content;
        $this->slug      = $slug;
        $this->isDefault = $isDefault;
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
}