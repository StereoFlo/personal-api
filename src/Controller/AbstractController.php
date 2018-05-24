<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Translation\TranslatorInterface;

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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var User|null
     */
    private $currentUser;

    /**
     * AbstractController constructor.
     *
     * @param SerializerInterface $serializer
     * @param TranslatorInterface $translator
     * @param User|null           $user
     */
    public function __construct(SerializerInterface $serializer, TranslatorInterface $translator, ?User $user)
    {
        $this->serializer  = $serializer;
        $this->translator  = $translator;
        $this->currentUser = $user;
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
     * @param string $message
     * @param int    $code
     * @param null   $additionalData
     *
     * @return JsonResponse
     */
    public function errorJson(string $message, int $code = 500, $additionalData = null): JsonResponse
    {
        $data = [
            'success' => false,
            'message' => $this->translator->trans($message),
        ];
        if ($additionalData) {
            $data['data'] = $additionalData;
        }
        return new JsonResponse($data, $code);
    }

    /**
     * @param string $message
     * @param int    $code
     * @param null   $additionalData
     *
     * @return JsonResponse
     */
    public function acceptJson(string $message, int $code = 202, $additionalData = null): JsonResponse
    {
        $data = [
            'success' => true,
            'message' => $this->translator->trans($message),
        ];
        if ($additionalData) {
            $data['data'] = $additionalData;
        }
        return new JsonResponse($data, $code);
    }

    /**
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return $this->currentUser;
    }
}