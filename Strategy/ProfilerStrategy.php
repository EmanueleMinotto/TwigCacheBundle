<?php

namespace EmanueleMinotto\TwigCacheBundle\Strategy;

use Twig\CacheExtension\CacheStrategyInterface;
use EmanueleMinotto\TwigCacheBundle\DataCollector\TwigCacheCollector;

/**
 * Wrapper used to profile cache usage.
 */
class ProfilerStrategy implements CacheStrategyInterface
{
    /**
     * @var CacheStrategyInterface
     */
    private $cacheStrategy;

    /**
     * @var TwigCacheCollector
     */
    private $dataCollector;

    /**
     * @param CacheStrategyInterface $cacheStrategy
     * @param TwigCacheCollector     $dataCollector
     */
    public function __construct(CacheStrategyInterface $cacheStrategy, TwigCacheCollector $dataCollector)
    {
        $this->cacheStrategy = $cacheStrategy;
        $this->dataCollector = $dataCollector;

        $dataCollector->setStrategyClass(get_class($cacheStrategy));
    }

    /**
     * Fetch the block for a given key.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function fetchBlock($key)
    {
        $output = $this->cacheStrategy->fetchBlock($key);
        $this->dataCollector->addFetchBlock($key, $output);

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
        $this->dataCollector->addGenerateKey($annotation, $value);

        return $this->cacheStrategy->generateKey($annotation, $value);
    }

    /**
     * Save the contents of a rendered block.
     *
     * @param mixed  $key
     * @param string $block
     *
     * @return mixed
     */
    public function saveBlock($key, $block)
    {
        return $this->cacheStrategy->saveBlock($key, $block);
    }
}
