<?php

namespace Glitch;

trait ConfigurableTrait
{
    /**
     * @inheritdoc
     *
     * @param array $defaults
     *
     * @return array
     */
    public function getConfig(array $defaults = [])
    {
        $config = $defaults;

        if ($this instanceof Configurable) {
            $config = array_replace_recursive($config, $this->onConfig($config));
        }

        if ($this instanceof Extensible) {
            foreach ($this->getExtensions() as $extension) {
                if ($extension instanceof Configurable) {
                    $config = array_replace_recursive($config, $extension->onConfig($config));
                }
            }
        }

        return $config;
    }
}
