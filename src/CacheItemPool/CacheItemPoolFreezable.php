<?php
declare(strict_types=1);
namespace Cl\Cache\CacheItemPool;

trait   CacheItemPoolFreezable
{
    protected bool $frozen = false;

    
    public function freeze(): void
    {
        $this->frozen = true;
    }

    public function unfreeze(): void
    {
        $this->frozen = false;
    }

    public function isFrozen(): bool
    {
        return $this->frozen;
    }
}
