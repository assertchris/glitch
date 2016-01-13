<?php

namespace Glitch;

/**
 * Returns a shared class instance.
 *
 * @param string $type
 *
 * @return mixed
 */
function share($type)
{
    static $extensions = [];

    if (empty($extensions[$type])) {
        $extensions[$type] = new $type;
    }

    return $extensions[$type];
}
