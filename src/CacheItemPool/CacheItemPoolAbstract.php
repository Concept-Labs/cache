<?php
namespace Cl\Cache\CacheItemPool;


use Cl\Cache\CacheItem\CacheItemKeyValidatorTrait;
use Cl\Cache\CacheItem\CacheKeyNormalizerTrait;


/**
 * Abstract class for implementing 
 * the ClCacheItemPoolInterface (Psr\Cache\CacheItemPoolInterface) interface.
 */
abstract class CacheItemPoolAbstract implements CacheItemPoolInterface
{
    use CacheItemPoolAbstractTrait;
    use CacheItemPoolDeferTrait;
    use CacheKeyNormalizerTrait;
    use CacheItemKeyValidatorTrait;
    use CacheItemPoolFreezable;

  

    /**
     * Get cache items by their keys.
     *
     * @param array $keys An array of keys.
     *
     * @return iterable An iterator containing CacheItemInterface objects.
     */
    public function getItems(array $keys = []): iterable
    {   
        foreach ($keys as $key) {
            if ($this->validateKey($key)) {
                yield $this->getItem($key);
            }
        }
    }

    /**
     * Delete cache items by their keys.
     *
     * @param array $keys An array of keys.
     *
     * @return bool Returns true if all items were successfully deleted.
     */
    public function deleteItems(array $keys): bool
    {
        return array_reduce(
            $keys,
            fn($carry, $key) 
                => $carry && $this->validateKey($key) && $this->deleteItem($key),
            true
        );
    }
}