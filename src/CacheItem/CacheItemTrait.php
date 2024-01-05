<?php
declare(strict_types=1);
namespace Cl\Cache\CacheItem;


trait CacheItemTrait
{
    use CacheKeyNormalizerTrait;
    use CacheItemPropertyAccessTrait;
    use CacheItemExpirationTrait;

    /**
     * Get the stored value from the cache item.
     *
     * @return mixed|null The stored value or null if the item is a miss.
     */
    public function get() : mixed
    {
        return $this->isHit() ? $this->getValue() : null;
    }

    /**
     * Set a new value for the cache item.
     *
     * @param mixed $value The new value to be stored.
     *
     * @return static The updated cache item.
     */
    public function set(mixed $value) : static
    {
        return $this->setValue(value: $value);
    }

    /**
     * Check if the cache item is a hit.
     *
     * @return bool True if the item is a hit and not expired, false otherwise.
     */
    public function isHit(): bool
    {
        return $this->getHit() && !$this->isExpired();
    }
}