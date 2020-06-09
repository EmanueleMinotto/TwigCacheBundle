<?php

namespace EmanueleMinotto\TwigCacheBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

class TwigCacheCollector implements DataCollectorInterface
{
    /**
     * @var string
     */
    private $strategyClass;

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

    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        // nothing to do here
    }

    /**
     * @return string The collector name
     */
    public function getName()
    {
        return 'asm89_cache';
    }

    /**
     * @param string $strategyClass
     */
    public function setStrategyClass($strategyClass)
    {
        $this->strategyClass = $strategyClass;
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
     * Reset profiler data.
     */
    public function reset()
    {
        $this->fetchBlock = [];
        $this->generateKey = [];
        $this->hits = 0;
    }
}
