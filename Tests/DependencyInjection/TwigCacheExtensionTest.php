<?php

namespace EmanueleMinotto\TwigCacheBundle\Tests\DependencyInjection;

use Doctrine\Common\Cache\ArrayCache;
use EmanueleMinotto\TwigCacheBundle\DependencyInjection\TwigCacheExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Component\DependencyInjection\Definition;

class TwigCacheExtensionTest extends AbstractExtensionTestCase
{
    /**
     * Return an array of container extensions you need to be registered for each test (usually just the container
     * extension you are testing.
     *
     * @return ExtensionInterface[]
     */
    protected function getContainerExtensions()
    {
        return [
            new TwigCacheExtension(),
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        $serviceId = sha1(rand());

        $this->setDefinition($serviceId, new Definition(ArrayCache::class));
        $this->load([
            'service' => $serviceId,
        ]);
    }

    /**
     * Test services.
     */
    public function testService()
    {
        $this->assertContainerBuilderHasService('twig_cache.extension');
        $this->assertContainerBuilderHasService('twig_cache.service');
        $this->assertContainerBuilderHasService('twig_cache.strategy.key_generator');
    }

    /**
     * Test parameters.
     */
    public function testParameter()
    {
        $this->assertContainerBuilderHasParameter('twig_cache.adapter.class');
        $this->assertContainerBuilderHasParameter('twig_cache.extension.class');
        $this->assertContainerBuilderHasParameter('twig_cache.strategy.class');
        $this->assertContainerBuilderHasParameter('twig_cache.strategy.generational.class');
        $this->assertContainerBuilderHasParameter('twig_cache.strategy.lifetime.class');
        $this->assertContainerBuilderHasParameter('twig_cache.strategy.spl_object_hash_key_generator.class');
    }
}
