<?php

namespace App\Services\Traits;

trait ValidationTrait
{
    /**
     * @param string $input
     * @param string $fact
     * @return bool
     */
    private static function doubleToOldString(string $input, string $fact): bool
    {
        return ($input === $fact);
    }
}
