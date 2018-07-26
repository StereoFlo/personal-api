<?php

namespace Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class EscapedJsonResponse
 * @package Infrastructure\Response
 */
class EscapedJsonResponse extends JsonResponse
{
    protected $encodingOptions = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
}