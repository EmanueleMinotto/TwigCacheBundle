<?php

namespace EmanueleMinotto\TwigCacheBundle\Tests\DependencyInjection;

use EmanueleMinotto\TwigCacheBundle\Tests\AppKernel;
use EmanueleMinotto\TwigCacheBundle\Twig\ProfilerExtension;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \EmanueleMinotto\TwigCacheBundle\Twig\ProfilerExtension
 */
class ProfilerExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    private $kernel;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->kernel = new AppKernel('TwigCacheExtensionTest', true);
        $this->kernel->boot();
    }

    /**
     * @covers ::serialize
     * @covers ::unserialize
     */
    public function testSerialization()
    {
        $container = $this->kernel->getContainer();

        $cacheStrategy = $container->get('twig_cache.strategy.generational');
        $extension = new ProfilerExtension($cacheStrategy);

        $extension->addFetchBlock('foo', true);
        $extension->addGenerateKey('generation_key', 123);

        $data = $extension->getData();

        $serializedData = serialize($extension);

        /** @var ProfilerExtension $unserialized */
        $unserialized = unserialize($serializedData);

        $this->assertInstanceOf('EmanueleMinotto\TwigCacheBundle\Twig\ProfilerExtension', $unserialized);
        $dataUnserialized = $unserialized->getData();

        $this->assertEquals($data, $dataUnserialized);
    }
}
