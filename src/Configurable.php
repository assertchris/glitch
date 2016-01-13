<?php

namespace Glitch;

interface Configurable
{
    /**
     * Returns a modified config array.
     *
     * @param array $config
     *
     * @return array
     */
    public function onConfig(array $config = []);

    /**
     * Returns final config array.
     *
     * @param array $defaults
     *
     * @return array
     */
    public function getConfig(array $defaults = []);
}
