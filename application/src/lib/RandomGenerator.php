<?php

declare(strict_types=1);

namespace App\lib;

use Exception;
use TypeError;

class RandomGenerator
{
    public static function generateBool(): bool
    {
        return 1 === self::generateInt(0, 1);
    }

    public static function generateInt(int $min, int $max): int
    {
        if (function_exists('random_int')) {
            try {
                return random_int($min, $max);
            } catch (TypeError $typeError) {
            } catch (Exception $exception) {
                @trigger_error(sprintf(
                    'Unable to muster enough entropy'
                ), E_USER_NOTICE);
            }
        }
        if (function_exists('mt_rand')) {
            return mt_rand($min, $max);
        }

        return rand($min, $max);
    }
}
