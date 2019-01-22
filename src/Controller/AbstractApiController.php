<?php

namespace Controller;

use Application\Response\EscapedJsonResponse;
use Domain\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

/**
 * Class AbstractApiController
 * @package Controller
 */
abstract class AbstractApiController
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var User|null
     */
    private $currentUser;

    /**
     * @param Serializer $serializer
     *
     * @return AbstractApiController
     */
    public function setSerializer(Serializer $serializer): AbstractApiController
    {
        $this->serializer = $serializer;
        return $this;
    }

    /**
     * @param Translator $translator
     *
     * @return AbstractApiController
     */
    public function setTranslator(Translator $translator): AbstractApiController
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * @param User|null $currentUser
     *
     * @return AbstractApiController
     */
    public function setCurrentUser(?User $currentUser): AbstractApiController
    {
        $this->currentUser = $currentUser;
        return $this;
    }

    /**
     * @param object|array      $data object|array to serialize and return
     * @param string|array|null $serializationGroup
     *
     * @param int               $code
     *
     * @return JsonResponse
     */
    public function json($data, $serializationGroup = null, int $code = 200): JsonResponse
    {
        $context['enable_max_depth'] = true;
        if ($serializationGroup) {
            switch (true) {
                case \is_array($serializationGroup):
                    $context['groups'] = $serializationGroup;
                    break;
                case \is_string($serializationGroup):
                    $context['groups'] = [$serializationGroup];
                    break;
            }
        }
        $data = $this->serializer->serialize([
            'success' => true,
            'message' => '',
            'data'    => $data,
        ], 'json', $context);
        return new EscapedJsonResponse($data, $code, [], true);
    }

    /**
     * @param int               $total
     * @param mixed             $data
     * @param string|array|null $serializationGroup
     * @param int               $code
     *
     * @return JsonResponse
     */
    public function dataJson(int $total, $data, $serializationGroup = null, int $code = 200): JsonResponse
    {
        return $this->json([
            'total' => $total,
            'items' => $data,
        ], $serializationGroup, $code);
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
        return new EscapedJsonResponse($data, $code);
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
        return new EscapedJsonResponse($data, $code, []);
    }

    /**
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return $this->currentUser;
    }
}