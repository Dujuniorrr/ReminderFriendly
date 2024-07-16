<?php

namespace Src\Application\DTO;

/**
 * Class BaseDTO
 * 
 * Abstract base class for Data Transfer Objects.
 */

abstract class BaseDTO
{

    /**
     * Converts the DTO to an array.
     * 
     * @return array The properties of the DTO as an associative array.
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
