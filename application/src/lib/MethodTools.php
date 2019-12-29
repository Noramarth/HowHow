<?php

declare(strict_types=1);

namespace App\lib;

use App\Constant\Common;

class MethodTools
{
    public static function getArgValues(array $arguments): string
    {
        $result = '';
        $values = [];
        foreach ($arguments as $argument) {
            if (is_scalar($argument)) {
                $values[] = $argument;

                continue;
            }
            if (is_array($argument)) {
                if (!empty($argument)) {
                    $values[] = 'Collection_' . hash('sha256', json_encode($argument));
                }

                continue;
            }
            if (is_object($argument)) {
                if (method_exists($argument, 'getId')) {
                    $values[] = $argument->getId();

                    continue;
                }
                if (property_exists($argument, 'id')) {
                    $values = $argument->id;

                    continue;
                }
            }
        }
        if (!empty($values)) {
            $result = implode(Common::CACHE_DELIMITER, $values);
        }

        return $result;
    }
}
