<?php
namespace Cl\Cache\FileSystem\File;


use Cl\Cache\CacheItemPool\CacheItemPoolAbstract;
use Cl\Cache\FileSystem\File\Exception\DeleteException;
use Cl\Cache\FileSystem\File\Exception\ReadException;
use Cl\Cache\FileSystem\File\Exception\WriteException;
use Psr\Cache\CacheItemInterface;

class CacheItemPool extends CacheItemPoolAbstract
{
    use CacheItemPoolConfigTrait;

    /**
     * @inheritDoc
     */
    public function write(array $items): bool
    {
        foreach ($items as $item) {
            try {
                $key = $item->getKey();
                $filePath = $this->getCacheFilePath($key);

                if (!is_dir(dirname($filePath))) {
                    mkdir(dirname($filePath), static::CACHE_FILE_PERMISSIONS, true);
                }
                if (!file_put_contents($filePath, serialize($item->get()), LOCK_EX)) {
                    throw new \Exception('Can\'t write to file');
                }

                return true;
            } catch (\Throwable $e) {
                throw new WriteException(sprintf('Error writting cache to file "%s"', $filePath));
//                return false;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function hasItem(string|\Stringable $key): bool
    {
        $filePath = $this->getCacheFilePath($key);
        return file_exists($filePath);
    }

    /**
     * @inheritDoc
     */
    public function getItem($key): CacheItemInterface
    {
        try {
            $filePath = $this->getCacheFilePath($key);

            if (file_exists($filePath)) {
                $serializedValue = file_get_contents($filePath);
                $value = unserialize($serializedValue);

                $cacheItem = new CacheItem($key, $value);
                //$cacheItem->setFilePath($filePath);

                return $cacheItem;
            }
        } catch (\Throwable $e) {
            //@TODO Handle exceptions, log, or rethrow as needed
            throw new ReadException(sprintf('Error reading cache file "%s"', $filePath));
        }
        return new CacheItem($key);
    }

    /**
     * @inheritDoc
     */
    public function deleteItem(string|\Stringable $key): bool
    {
        try {
            $filePath = $this->getCacheFilePath($key);
            if (file_exists($filePath)) {
                return unlink($filePath);
            }

            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        try {
            $cacheDirectory = $this->getBasePath();
            $files = glob($cacheDirectory . '/*');

            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
                if (is_dir($file)) {
                    rmdir($file);
                }
            }

            return true;
        } catch (\Throwable $e) {
            throw new DeleteException(sprintf('Unable to delete file "%s"', $file));
        }
    }

}
