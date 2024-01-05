<?php
namespace Cl\Cache\FileSystem\File;

use Cl\Config\ConfigInterface;

trait CacheItemPoolConfigTrait
{
    protected array $config;

    protected string $basePath = '/tmp/.cl-cache';

    const CACHE_FILE_PERMISSIONS = 0750;

    /**
     * Get base path for chache files
     *
     * @return string
     */
    protected function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Sets the base path
     *
     * @param string $path 
     * 
     * @return void
     */
    public function setBasePath(string$path): void
    {
        $this->basePath = $path;
    }

    /**
     * Undocumented function
     *
     * @param string|\Stringable $key 
     * 
     * @return string
     */
    protected function getCacheFilePath(string|\Stringable $key): string
    {
        $cacheKey = $this->normalizeKey($key);

        $filePath = sprintf("%s/%s/%s.cache", $this->getBasePath(), substr($cacheKey, 0, 1), $cacheKey);

        return $filePath;
    }

}