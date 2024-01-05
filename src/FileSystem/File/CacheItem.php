<?php
namespace Cl\Cache\Filesystem\File;

use Cl\Cache\CacheItem\CacheItemAbstract;

class CacheItem extends CacheItemAbstract
{
    protected string $filePath = '';

    /**
     * Cache item filepath
     *
     * @param string $path
     * @return void
     */
    public function setFilePath( string $path ): void
    {
        $this->filePath = $path;
    }

    /**
     * Get item filepath
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }
}