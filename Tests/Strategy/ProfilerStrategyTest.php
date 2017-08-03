<?php

namespace EmanueleMinotto\TwigCacheBundle\Tests\Strategy;

use Asm89\Twig\CacheExtension\CacheStrategyInterface;
use EmanueleMinotto\TwigCacheBundle\Strategy\ProfilerStrategy;
use EmanueleMinotto\TwigCacheBundle\Twig\ProfilerExtension;
use PHPUnit_Framework_TestCase;

class ProfilerStrategyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ProfilerStrategy
     */
    protected $object;

    /**
     * @var CacheStrategyInterface
     */
    private $cacheStrategy;

    /**
     * @var ProfilerExtension
     */
    private $profilerExtension;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->cacheStrategy = $this
            ->getMockBuilder(CacheStrategyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->profilerExtension = $this
            ->getMockBuilder(ProfilerExtension::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new ProfilerStrategy(
            $this->cacheStrategy,
            $this->profilerExtension
        );
    }

    public function testFetchBlock()
    {
        $key = sha1(rand());
        $output = sha1(rand());

        $this->cacheStrategy
            ->method('fetchBlock')
            ->will($this->returnCallback(function ($a) use ($key, $output) {
                $this->assertSame($key, $a);

                return $output;
            }));

        $this->profilerExtension
            ->method('addFetchBlock')
            ->will($this->returnCallback(function ($a, $b) use ($key, $output) {
                $this->assertSame($key, $a);
                $this->assertSame($output, $b);
            }));

        $this->object->fetchBlock($key);
    }

    public function testGenerateKey()
    {
        $annotation = sha1(rand());
        $value = sha1(rand());

        $this->profilerExtension
            ->method('addGenerateKey')
            ->will($this->returnCallback(function ($a, $b) use ($annotation, $value) {
                $this->assertSame($annotation, $a);
                $this->assertSame($value, $b);
            }));

        $this->cacheStrategy
            ->method('generateKey')
            ->will($this->returnCallback(function ($a, $b) use ($annotation, $value) {
                $this->assertSame($annotation, $a);
                $this->assertSame($value, $b);
            }));

        $this->object->generateKey($annotation, $value);
    }

    public function testSaveBlock()
    {
        $key = sha1(rand());
        $block = sha1(rand());

        $this->cacheStrategy
            ->method('saveBlock')
            ->will($this->returnCallback(function ($a, $b) use ($key, $block) {
                $this->assertSame($key, $a);
                $this->assertSame($block, $b);
            }));

        $this->object->saveBlock($key, $block);
    }
}
