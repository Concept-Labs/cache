<?php
use Cl\Cache\FileSystem\File\CacheItem;
use PHPUnit\Framework\TestCase;
use Cl\Cache\CacheItemPool\CacheItemPoolInterface;
use Cl\Cache\FileSystem\File\CacheItemPool;
use Psr\Cache\CacheItemInterface;


/**
 * @covers Cl\Cache\FileSystem\File\CacheItemPool
 */
class FileCacheItemPoolTest extends TestCase
{
    protected CacheItemPoolInterface $cache;

    protected function setUp(): void
    {
        $this->cache = new CacheItemPool();
    }

    public function testCacheItemPoolInterface()
    {
        // Arrange
        $cacheItemPool = new CacheItemPool(); 

        // Act & Assert
        $this->assertInstanceOf(CacheItemPoolInterface::class, $cacheItemPool);
        $this->assertInstanceOf(\Psr\Cache\CacheItemPoolInterface::class, $cacheItemPool);
    }

    public function testCacheItemInterface()
    {
        // Arrange
        $key = 'test_key';
        $value = 'test_value';
        $expiration = new \DateTime('+1 hour');
        $ext = [
            'ext_test_object' => new stdClass(),
            'ext_test_array' => [1,2,3],
            'ext_test_value' => 'test value',
        ];

        $cacheItem = new CacheItem($key, $value, $expiration);

        // Act & Assert
        $this->assertInstanceOf(CacheItemInterface::class, $cacheItem);
        $this->assertInstanceOf(\Psr\Cache\CacheItemInterface::class, $cacheItem);

    }

    public function testGetItem()
    {
        $key = 'test_key';
        $item = $this->cache->getItem($key);

        $this->assertInstanceOf(CacheItemInterface::class, $item);
        $this->assertEquals($key, $item->getKey());
    }

    public function testGetItems()
    {
        $keys = ['key1', 'key2'];
        $items = $this->cache->getItems($keys);

        foreach ($items as $item) {
            $this->assertInstanceOf(CacheItemInterface::class, $item);
            $this->assertTrue(in_array($item->getKey(), $keys));
        }

    }

    public static function itemProvider()
    {
        return [
            ['firstem.test', 'test item content'],
            ['another', 'some else'],
            ['third', 'more content'],
        ];
    }

    /**

     * @dataProvider itemProvider
     */
    public function testItemSaveAndGetSuccess($key, $content)
    {
        $item = $this->cache->getItem($key);
        $item->set($content);
        $this->cache->save($item);

        $this->assertTrue($this->cache->hasItem($item->getKey()));

        $savedItem = $this->cache->getItem($key);
        $this->assertSame($item->get(), $savedItem->get());
    }

    public function testDeleteSuccess()
    {
        $item = $this->cache->getItem('deleteKey');
        $item->set('$content');

        $this->cache->save($item);

        $this->assertTrue($this->cache->hasItem($item->getKey()));

        $this->cache->deleteItem($item->getKey());

        $this->assertFalse($this->cache->hasItem($item->getKey()));
    }

    public function testClear()
    {
        $item = $this->cache->getItem('$key');
        $item->set('$content');
        $this->cache->save($item);

        $this->assertTrue($this->cache->hasItem($item->getKey()));
        $this->cache->clear();

        $savedItem = $this->cache->hasItem('$key');
        $this->assertFalse($savedItem);
    }

}