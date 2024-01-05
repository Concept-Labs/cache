<?php
namespace Cl\Cache\InMemory;

use Cl\Cache\CacheItem\CacheItemInterface;
use Cl\Cache\CacheItemPool\CacheItemPoolAbstract;

/**
 * Class with implementation 
 * the ClCacheItemPoolInterface (Psr\Cache\CacheItemPoolInterface) interface
 * with in-memory storage
 */
class InMemoryCacheItemPool extends CacheItemPoolAbstract
{
    /**
     * Cache storage
     *
     * @var array
     */
    protected array $cache = [];

    /**
     * @inheritDoc
     */
    public function write(array $items): bool
    {
        foreach ($items as $item) {
            $this->cache[$item->getKey()] = clone $item;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function hasItem(string|\Stringable $key): bool
    {
        return array_key_exists($this->normalizeKey($key), $this->cache);
    }

    /**
     * @inheritDoc
     */
    public function getItem($key): CacheItemInterface
    {
        $cacheKey = $this->normalizeKey($key);
        return match (true) {
            $this->hasItem($key) => clone $this->cache[$cacheKey],
            //@TODO
            default => (new InMemoryCacheItem($cacheKey))
        };
    }

    /**
     * @inheritDoc
     */
    public function deleteItem(string|\Stringable $key): bool
    {
        unset($this->cache[$this->normalizeKey($key)]);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        return array_reduce(
            $this->cache,
            fn($carry, $item) => $carry && $this->deleteItem($item->getKey),
            true
        );
    }

}