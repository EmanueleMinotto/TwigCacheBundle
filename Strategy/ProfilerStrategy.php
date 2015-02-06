<?php

namespace EmanueleMinotto\TwigCacheBundle\Strategy;

use Asm89\Twig\CacheExtension\CacheStrategyInterface;
use EmanueleMinotto\TwigCacheBundle\Twig\ProfilerExtension;

/**
 * Wrapper used to profile cache usage.
 */
class ProfilerStrategy implements CacheStrategyInterface
{
    /**
     * @var ProfilerExtension
     */
    private $profilerExtension;

    /**
     * @var CacheStrategyInterface
     */
    private $cacheStrategy;

    /**
     * @param CacheStrategyInterface $cacheStrategy
     * @param ProfilerExtension      $profilerExtension
     */
    public function __construct(CacheStrategyInterface $cacheStrategy, ProfilerExtension $profilerExtension)
    {
        $this->cacheStrategy = $cacheStrategy;
        $this->profilerExtension = $profilerExtension;
    }

    /**
     * Fetch the block for a given key.
     *
     * @param mixed $key
     *
     * @return string
     */
    public function fetchBlock($key)
    {
        $output = $this->cacheStrategy->fetchBlock($key);
        $this->profilerExtension->addFetchBlock($key, $output);

        return $output;
    }

    /**
     * Generate a key for the value.
     *
     * @param string $annotation
     * @param mixed  $value
     *
     * @return mixed
     */
    public function generateKey($annotation, $value)
    {
        $this->profilerExtension->addGenerateKey($annotation, $value);

        return $this->cacheStrategy->generateKey($annotation, $value);
    }

    /**
     * Save the contents of a rendered block.
     *
     * @param mixed  $key
     * @param string $block
     */
    public function saveBlock($key, $block)
    {
        return $this->cacheStrategy->saveBlock($key, $block);
    }
}
