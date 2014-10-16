<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\Adapter\MemoryAdapter\KeyTrait;
use AdammBalogh\KeyValueStore\Adapter\MemoryAdapter\ValueTrait;
use AdammBalogh\KeyValueStore\Adapter\MemoryAdapter\ServerTrait;

class MemoryAdapter extends AbstractAdapter
{
    use KeyTrait, ValueTrait, ServerTrait;

    /**
     * @var null
     */
    protected $client;

    /**
     * @var array
     */
    protected $store = [];

    /**
     * @return null
     */
    public function getClient()
    {
        return $this->client;
    }
}
