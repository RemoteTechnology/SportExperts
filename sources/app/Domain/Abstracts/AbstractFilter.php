<?php

namespace App\Domain\Abstracts;

use Sajya\Server\Procedure;

abstract class AbstractFilter extends Procedure
{

    /**
     * @param mixed $attributes
     * @return array
     */
    public function formatDate(mixed $attributes): array
    {
        $data = [];
        $filter = explode(',', str_replace(' ', '', $attributes['filter']));
        foreach ($filter as $item) {
            list($key, $value) = explode(':', $item);
            $data[$key] = $value;
        }
        return $data;
    }
}
