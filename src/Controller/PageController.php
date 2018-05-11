<?php

namespace App\Controller;

use App\Repository\Page\PageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PageController
 * @package App\Controller
 */
class PageController
{
    /**
     * @var PageInterface
     */
    private $pageRepo;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * PageController constructor.
     *
     * @param PageInterface       $page
     * @param SerializerInterface $serializer
     */
    public function __construct(PageInterface $page, SerializerInterface $serializer)
    {
        $this->pageRepo   = $page;
        $this->serializer = $serializer;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $defaultPage = $this->pageRepo->getDefaultPage();
        if (empty($defaultPage)) {
            return JsonResponse::create(['success' => false, 'message' => 'page does not found'], 404);
        }

        $data = $this->serializer->serialize(['success' => true, 'data' => $defaultPage], 'json');

        return JsonResponse::create(\json_decode($data));
    }

    /**
     * @param string $slug
     *
     * @return JsonResponse
     */
    public function getPage(string $slug): JsonResponse
    {
        $page = $this->pageRepo->getBySlug($slug);
        if (empty($page)) {
            return JsonResponse::create(['success' => false, 'message' => 'page does not found'], 404);
        }
        $data = $this->serializer->serialize(['success' => true, 'data' => $page], 'json');
        return JsonResponse::create(\json_decode($data));
    }
}