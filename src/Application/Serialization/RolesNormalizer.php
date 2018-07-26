<?php

namespace Application\Serialization;

use Entity\Roles;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class RolesNormalizer
 * @package Application\Serialization
 */
class RolesNormalizer implements NormalizerInterface
{
    /**
     * @param object $object
     * @param null   $format
     * @param array  $context
     *
     * @return string
     * @throws \Exception
     */
    public function normalize($object, $format = null, array $context = []): string
    {
        if (\in_array(Roles::ROLE_ADMIN, $object->getList())) {
            return 'admin';
        }

        if (\in_array(Roles::ROLE_USER, $object->getList())) {
            return 'user';
        }

        throw new \Exception('забыли обновить нормалайзер');
    }

    /**
     * @param mixed $data
     * @param null  $format
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Roles;
    }
}