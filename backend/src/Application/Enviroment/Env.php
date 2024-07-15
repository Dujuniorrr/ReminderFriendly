<?php

namespace Src\Application\Enviroment;

interface Env
{
    /**
     * Retrieve the value associated with a specific configuration key.
     *
     * This method fetches the value of a configuration setting identified by the provided key.
     * If the key does not exist, the specified default value is returned instead.
     *
     * @param string $key The configuration key whose value is to be retrieved.
     * @param mixed $default The default value to return if the key is not found. Defaults to null.
     * @return mixed The value associated with the specified key, or the default value if the key does not exist.
     */
    function get(string $key, mixed $default = null): mixed;
}
