<?php

namespace EmanueleMinotto\TwigCacheBundle\Twig;

use Asm89\Twig\CacheExtension\CacheStrategyInterface;
use Asm89\Twig\CacheExtension\Extension as Asm89_Extension;
use EmanueleMinotto\TwigCacheBundle\Strategy\ProfilerStrategy;
use Exception;
use Serializable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

/**
 * {@inheritdoc}
 */
class ProfilerExtension extends Asm89_Extension implements DataCollectorInterface, Serializable
{
    /**
     * Data about fetchBlock requests.
     *
     * @var array
     */
    private $fetchBlock = [];

    /**
     * Data about generateKey requests.
     *
     * @var array
     */
    private $generateKey = [];

    /**
     * Cache hits.
     *
     * @var int
     */
    private $hits = 0;

    /**
     * Caching strategy used.
     *
     * @var string
     */
    private $strategyClass;

    /**
     * @param CacheStrategyInterface $cacheStrategy
     */
    public function __construct(CacheStrategyInterface $cacheStrategy)
    {
        parent::__construct(new ProfilerStrategy($cacheStrategy, $this));

        $this->strategyClass = get_class($cacheStrategy);
    }

    /**
     * Collects data for the given Request and Response.
     *
     * @param Request   $request   A Request instance
     * @param Response  $response  A Response instance
     * @param Exception $exception An Exception instance
     */
    public function collect(Request $request, Response $response, Exception $exception = null)
    {
        // nothing to do here
    }

    /**
     * Store a fetch request.
     *
     * @param mixed  $key
     * @param string $output
     */
    public function addFetchBlock($key, $output)
    {
        $this->fetchBlock[] = [$key, $output];

        if ($output) {
            ++$this->hits;
        }
    }

    /**
     * Store a generateKey request.
     *
     * @param string $annotation
     * @param mixed  $value
     */
    public function addGenerateKey($annotation, $value)
    {
        $this->generateKey[] = [
            'annotation' => $annotation,
            'value' => $value,
        ];
    }

    /**
     * Get data stored in this profiler.
     *
     * @return array
     */
    public function getData()
    {
        return [
            'fetchBlock' => $this->fetchBlock,
            'generateKey' => $this->generateKey,
            'hits' => $this->hits,
            'strategyClass' => $this->strategyClass,
        ];
    }

    /**
     * String representation of object.
     *
     * @see http://php.net/manual/en/serializable.serialize.php
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->getData());
    }

    /**
     * Constructs the object.
     *
     * @see http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized the string representation of the object
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        if (is_array($data)) {
            $this->fetchBlock = $data['fetchBlock'];
            $this->generateKey = $data['generateKey'];
            $this->hits = $data['hits'];
            $this->strategyClass = $data['strategyClass'];
        }
    }

    /**
     * Reset profiler data.
     */
    public function reset()
    {
        $this->fetchBlock = [];
        $this->generateKey = [];
        $this->hits = 0;
    }
}
