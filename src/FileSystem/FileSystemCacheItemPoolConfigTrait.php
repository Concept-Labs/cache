<?php
namespace Cl\Cache\FileSystem;
trait FileSystemCacheItemPoolConfigTrait
{
    protected array $config;

    protected function getBasePath()
    {
        return '/tmp/';
    }

    protected function getCacheFilePath(string|\Stringable|callable $key)
    {
        $cacheKey = $this->normalizeKey($key);
        $filePath = sprintf("%s%s.cache", $this->getBasePath(), $cacheKey);
        return $filePath;
    }
}