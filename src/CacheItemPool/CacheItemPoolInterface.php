<?php
/**
 * PSR-6 CacheItemPoolInterface
 * 
 * @category  Library
 * @package   Cl\Cache
 * @author    Victor Galitsky <concept.galitsk@gmail.com>
 * @copyright 2023 (C)oncept-labs
 * @license   MIT 
 * @link      g
 */
namespace Cl\Cache\CacheItemPool;

use \Psr\Cache\CacheItemPoolInterface as PsrCacheItemPoolInterface;
use Cl\Able\Freezable\FreezableInterface;

/**
 * {@inheritDoc}
 */
interface CacheItemPoolInterface extends PsrCacheItemPoolInterface, FreezableInterface
{

    
}