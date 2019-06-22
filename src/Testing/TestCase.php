<?php

namespace StrawKit\Framework\Testing;

class TestCase
{
    /**
     * @var array
     */
    protected $config;

    final public function __construct(array $config)
    {
        $this->config = $config;
    }
}