<?php

namespace Glitch;

use function Glitch\share;

trait ExtensibleTrait
{
    /**
     * Stores extension references to this class.
     *
     * @var array
     */
    protected $extensions = [];

    /**
     * @inheritdoc
     *
     * @param string $event
     * @param mixed $context
     *
     * @return mixed
     */
    public function extend($event, $context = null)
    {
        foreach ($this->extensions as $extension) {
            $context = call_user_func_array([$extension, $event], [$this, $context]);
        }

        return $context;
    }

    /**
     * @inheritdoc
     *
     * @param string $type
     */
    public function addExtension($type)
    {
        $this->extensions[$type] = share($type);
    }

    /**
     * @inheritdoc
     *
     * @param string $type
     */
    public function removeExtension($type)
    {
        $this->extensions = array_filter($this->extensions, function($extension) use ($type) {
            return get_class($extension) !== $type;
        });
    }

    /**
     * @inheritdoc
     *
     * @return Extension[]
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
}
