<?php

namespace EmanueleMinotto\TwigCacheBundle\Tests\KeyGenerator;

use EmanueleMinotto\TwigCacheBundle\KeyGenerator\SplObjectHashKeyGenerator;
use PHPUnit_Framework_TestCase;
use stdClass;

class SplObjectHashKeyGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testGenerateKeySingle()
    {
        $generator = new SplObjectHashKeyGenerator();

        $this->assertInstanceOf(
            'Asm89\Twig\CacheExtension\CacheStrategy\KeyGeneratorInterface',
            $generator
        );

        $result = $generator->generateKey('foo');
        $this->assertSame(sha1(serialize('foo')), $result);

        $result = $generator->generateKey(new stdClass());
        $this->assertSame(spl_object_hash(new stdClass()), $result);
    }

    /**
     * @dataProvider valueProvider
     */
    public function testGenerateKey($value)
    {
        $generator = new SplObjectHashKeyGenerator();

        $this->assertRegExp('/[a-z0-9]{20,20}/', $generator->generateKey($value));
    }

    /**
     * @return array
     */
    public function valueProvider()
    {
        return [
            [new stdClass()],
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
