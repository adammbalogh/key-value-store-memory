<?php namespace AdammBalogh\KeyValueStore\Adapter\MemoryAdapter;

use AdammBalogh\KeyValueStore\Adapter\Util;
use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
trait ValueTrait
{
    /**
     * Gets the value of a key.
     *
     * @param string $key
     *
     * @return mixed The value of the key.
     *
     * @throws KeyNotFoundException
     */
    public function get($key)
    {
        if (!array_key_exists($key, $this->store)) {
            throw new KeyNotFoundException();
        }

        $getResult = $this->store[$key];
        $unserialized = @unserialize($getResult);

        if (Util::hasInternalExpireTime($unserialized)) {
            $getResult = $unserialized['v'];
        }

        return $getResult;
    }

    /**
     * Sets the value of a key.
     *
     * @param string $key
     * @param mixed $value Can be any of serializable data type.
     *
     * @return bool True if the set was successful, false if it was unsuccessful.
     */
    public function set($key, $value)
    {
        $this->store[$key] = $value;

        return true;
    }

    /**
     * If ttl is lesser or equals 0 delete key.
     *
     * @param string $key
     * @param int $expireSetTs
     * @param int $expireSec
     *
     * @return int ttl
     *
     * @throws KeyNotFoundException
     */
    protected function handleTtl($key, $expireSetTs, $expireSec)
    {
        $ttl = $expireSetTs + $expireSec - time();
        if ($ttl <= 0) {
            $this->delete($key);
            throw new KeyNotFoundException();
        }

        return $ttl;
    }
}
