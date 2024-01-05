<?php
namespace Cl\Cache\CacheItemPool;

use Psr\Cache\CacheItemInterface;

/**
 * Trait providing deferred cache item saving functionality.
 */
trait CacheItemPoolDeferTrait
{

    /**
     * @var CacheItemInterface[] The array to store deferred cache items.
     */
    protected array $deferred = [];

    /**
     * {@inheritdoc}
     */
    public function save(CacheItemInterface $item): bool
    {
        return $this->write([$item]);
    }

    /**
     * Save a cache item in a deferred state.
     *
     * @param CacheItemInterface $item The cache item to save.
     * 
     * @return bool True if the item was successfully saved; otherwise, false.
     */
    public function saveDeferred(CacheItemInterface $item): bool
    {
        $this->deferred[] = clone $item;
        return true;
    }

    /**
     * Commit all deferred cache items.
     *
     * @return bool True if all deferred items were successfully committed; otherwise, false.
     */
    public function commit(): bool
    {
        $success = $this->write($this->deferred);
        if ($success) {
            $this->deferred = [];
        }
        return $success;
    }
    
    /**
     * Commits the specified cache items to storage.
     *
     * @param CacheItemInterface[] $items
     *
     * @return bool
     *   TRUE if all provided items were successfully saved. FALSE otherwise.
     */
    abstract protected function write(array $items): bool;
}