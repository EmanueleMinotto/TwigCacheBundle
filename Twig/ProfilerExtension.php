<?php

namespace EmanueleMinotto\TwigCacheBundle\Twig;

use Asm89\Twig\CacheExtension\CacheStrategyInterface;
use Asm89\Twig\CacheExtension\Extension as Asm89_Extension;
use EmanueleMinotto\TwigCacheBundle\Strategy\ProfilerStrategy;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

/**
 * {@inheritdoc}
 */
class ProfilerExtension extends Asm89_Extension implements DataCollectorInterface
{
    /**
     * Data about fetchBlock requests.
     *
     * @var array
     */
    private $fetchBlock = array();

    /**
     * Data about generateKey requests.
     *
     * @var array
     */
    private $generateKey = array();

    /**
     * Cache hits.
     *
     * @var integer
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
     * @param mixed   $key
     * @param boolean $output
     */
    public function addFetchBlock($key, $output)
    {
        $this->fetchBlock[] = array($key, $output);

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
        $this->generateKey[] = array(
            'annotation' => $annotation,
            'value' => $value,
        );
    }

    /**
     * Get data stored in this profiler.
     *
     * @return array
     */
    public function getData()
    {
        return array(
            'fetchBlock' => $this->fetchBlock,
            'generateKey' => $this->generateKey,
            'hits' => $this->hits,
            'strategyClass' => $this->strategyClass,
        );
    }
}
