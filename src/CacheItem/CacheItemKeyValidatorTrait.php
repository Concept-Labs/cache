<?php
declare(strict_types=1);
namespace Cl\Cache\CacheItem;

use Cl\Cache\Exception\InvalidArgumentException;

trait CacheItemKeyValidatorTrait
{
    const PSR6_RESERVED = "{}()/\@:";

    /**
     * Determines if the specified key is legal under PSR-6.
     *
     * @param $key The key to validate.
     * 
     * @throws InvalidArgumentException
     *   An exception implementing The Cache InvalidArgumentException interface
     *   will be thrown if the key does not validate.
     * @return bool
     */
    protected function validateKey($key): bool
    {
        if (!is_string($key) || $key === '') {
            throw new InvalidArgumentException('Key should be a non empty string');
        }

        if (strpbrk($key, static::PSR6_RESERVED)) {
                    throw new InvalidArgumentException(sprintf('Can\'t validate the specified key: %s', $key));
        }

        return true;
    }
}