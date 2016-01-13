<?php

namespace Glitch;

interface Extensible
{
    /**
     * Provides context to extension method overrides, and returns the same context structure.
     *
     * @param string $event
     * @param mixed $context
     *
     * @return mixed
     */
    public function extend($event, $context = null);

    /**
     * Adds an extension to this class.
     *
     * @param string $type
     */
    public function addExtension($type);

    /**
     * Removes an extension from this class.
     *
     * @param string $type
     */
    public function removeExtension($type);

    /**
     * Returns an array of extension object references.
     *
     * @return Extension[]
     */
    public function getExtensions();
}