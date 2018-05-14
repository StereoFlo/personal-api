<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractController
 * @package App\Controller
 */
class AbstractController
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * AbstractController constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param object|array $data object|array to serialize and return
     * @param string       $serializationGroup
     *
     * @param int          $code
     *
     * @return JsonResponse
     */
    public function json($data, string $serializationGroup = null, int $code = 200): JsonResponse
    {
        $context['enable_max_depth'] = true;
        if ($serializationGroup) {
            $context['groups'] = [$serializationGroup];
        }
        $data = [
            'success' => true,
            'message' => '',
            'data'    => $data,
        ];
        $data = $this->serializer->serialize($data, 'json', $context);
        return new JsonResponse($data, $code, [], true);
    }

    /**
     * @param     $message
     * @param     $data
     * @param int $code
     *
     * @return JsonResponse
     */
    public function errorJson($message, $data, int $code = 500): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'message' => $message,
            'data'    => $data
        ], $code);
    }
}