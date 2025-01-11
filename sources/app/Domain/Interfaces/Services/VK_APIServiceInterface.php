<?php

namespace App\Domain\Interfaces\Services;

interface VK_APIServiceInterface
{
    /**
     * @param array $attributes
     * @return array
     */
    public function getUser(array $attributes): array;
}
