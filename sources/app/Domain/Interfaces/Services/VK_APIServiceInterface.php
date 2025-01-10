<?php

namespace App\Domain\Interfaces\Services;

use Psr\Http\Message\StreamInterface;

interface VK_APIServiceInterface
{
    /**
     * @param array $attributes
     * @return array
     */
    public function getUser(array $attributes): array;
}
