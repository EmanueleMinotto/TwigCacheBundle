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
        return array(
            array(new \stdClass()),
            array(array()),
            array('foo'),
            array('bar'),
            array(5),
            array(89),
            array(5.7),
            array(9.3),
            array(true),
            array(false),
        );
    }
}
