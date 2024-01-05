<?php

namespace Cl\Cache\Test;

use Cl\Cache\Exception\InvalidArgumentException;
use Cl\Cache\InMemory\InMemoryCacheItem;
use Cl\Cache\InMemory\InMemoryCacheItemPool;
use PHPUnit\Framework\TestCase;


/**
 * @covers Cl\Cache\CacheItem\CacheItemKeyValidatorTrait
 */
class KeyValidatorTest extends TestCase
{
    /** @var MemoryPool */
    protected $pool;

    protected function setUp(): void
    {
        $this->pool = new InMemoryCacheItemPool();
    }

    /**
     * 
     * @dataProvider providerValidKeyNamesStatic
     */
    public function testPositiveValidateKey($key)
    {
        static::assertInstanceOf(InMemoryCacheItem::class, $this->pool->getItem($key));
    }

    /**
     * Provides a set of valid test key names.
     *
     * @return array
     */
    public static function providerValidKeyNamesStatic(): array
    {
        return [
            ['bar'],
            ['barFoo1234567890'],
            ['bar_Foo.1'],
            ['1'],
            [str_repeat('a', 64)]
        ];
    }

    /**
     * Verifies key's name in negative cases.
     *
     * @param string $key
     *   The key's name.
     *
     * @expectedException InvalidArgumentException
     * @dataProvider providerNotValidKeyNamesStatic
     */
    public function testNegativeValidateKey($key): void
    {
        $this->expectException(InvalidArgumentException::class);
        $item = $this->pool->getItem($key);
    }

    /**
     * Provides a set of not valid test key names.
     *
     * @return array
     */
    public static function providerNotValidKeyNamesStatic(): array
    {
        return [
            [null],
            [1],
            [''],
            ['bar{Foo'],
            ['bar}Foo'],
            ['bar(Foo'],
            ['bar)Foo'],
            ['bar/Foo'],
            ['bar\Foo'],
            ['bar@Foo'],
            ['bar:Foo']
        ];
    }
}
