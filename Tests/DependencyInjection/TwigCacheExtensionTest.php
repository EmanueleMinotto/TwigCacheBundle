<?php

namespace EmanueleMinotto\TwigCacheBundle\Tests\DependencyInjection;

use EmanueleMinotto\TwigCacheBundle\Tests\AppKernel;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \EmanueleMinotto\TwigCacheBundle\DependencyInjection\TwigCacheExtension
 */
class TwigCacheExtensionTest extends PHPUnit_Framework_TestCase
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
     * @covers ::load
     */
    public function testService()
    {
        $container = $this->kernel->getContainer();

        $this->assertTrue($container->has('twig_cache.extension'));
        $this->assertInstanceOf('Twig_Extension', $container->get('twig_cache.extension'));

        $this->assertTrue($container->has('twig_cache.service'));
        $this->assertInstanceOf('Doctrine\\Common\\Cache\\Cache', $container->get('twig_cache.service'));
    }

    /**
     * @covers ::load
     */
    public function testParameter()
    {
        $container = $this->kernel->getContainer();

        $this->assertTrue($container->hasParameter('twig_cache.adapter.class'));
        $this->assertTrue($container->hasParameter('twig_cache.extension.class'));
        $this->assertTrue($container->hasParameter('twig_cache.strategy.class'));
        $this->assertTrue($container->hasParameter('twig_cache.strategy.generational.class'));
        $this->assertTrue($container->hasParameter('twig_cache.strategy.lifetime.class'));
        $this->assertTrue($container->hasParameter('twig_cache.strategy.spl_object_hash_key_generator.class'));
    }
}
