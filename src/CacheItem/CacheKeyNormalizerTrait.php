<?php
declare(strict_types=1);
namespace Cl\Cache\CacheItem;


use Cl\Cache\Exception\InvalidArgumentException;
use Cl\Cache\CacheItem\CacheItemKeyValidatorTrait;

/**
 * Trait providing key encoding and decoding functionality.
 */
trait CacheKeyNormalizerTrait
{
    use CacheItemKeyValidatorTrait;

    /**
     * Extract a cache item key.
     *
     * @param $key The cache item key.
     *
     * @return string The extracted cache item key.
     * @throws InvalidArgumentException If the key is of an invalid type.
     */
    protected function normalizeKey($key): string
    {
        // @TODO callable can be normalized
        $this->validateKey($key);
        
        return $key;
    }

    
}