<?php

namespace EmanueleMinotto\TwigCacheBundle\KeyGenerator;

use Twig\CacheExtension\CacheStrategy\KeyGeneratorInterface;

/**
 * Key generator based on spl_object_hash.
 *
 * @see https://github.com/twigphp/twig-cache-extension#setup-1
 */
class SplObjectHashKeyGenerator implements KeyGeneratorInterface
{
    /**
     * Generate a cache key for a given value.
     *
     * @param mixed $value cached value
     *
     * @return string
     */
    public function generateKey($value)
    {
        if (is_object($value)) {
            return spl_object_hash($value);
        }

        return sha1(serialize($value));
    }
}
