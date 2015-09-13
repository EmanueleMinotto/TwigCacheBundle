<?php

namespace EmanueleMinotto\TwigCacheBundle\Tests\KeyGenerator;

use EmanueleMinotto\TwigCacheBundle\KeyGenerator\SplObjectHashKeyGenerator;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \EmanueleMinotto\TwigCacheBundle\KeyGenerator\SplObjectHashKeyGenerator
 */
class SplObjectHashKeyGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::generateKey
     */
    public function testGenerateKeySingle()
    {
        $generator = new SplObjectHashKeyGenerator();

        $interface = 'Asm89\\Twig\\CacheExtension\\CacheStrategy\\KeyGeneratorInterface';
        $this->assertInstanceOf($interface, $generator);

        $result = $generator->generateKey('foo');
        $this->assertSame(sha1(serialize('foo')), $result);

        $result = $generator->generateKey(new \stdClass());
        $this->assertSame(spl_object_hash(new \stdClass()), $result);
    }

    /**
     * @covers ::generateKey
     * @dataProvider valueProvider
     */
    public function testGenerateKey($value)
    {
        $generator = new SplObjectHashKeyGenerator();

        $interface = 'Asm89\\Twig\\CacheExtension\\CacheStrategy\\KeyGeneratorInterface';
        $this->assertInstanceOf($interface, $generator);

        $result = $generator->generateKey($value);

        $this->assertRegExp('/[a-z0-9]{20,20}/', $result);
    }

    /**
     * @return array
     */
    public function valueProvider()
    {
        return [
            [new \stdClass()],
            [[]],
            ['foo'],
            ['bar'],
            [5],
            [89],
            [5.7],
            [9.3],
            [true],
            [false],
        ];
    }
}
