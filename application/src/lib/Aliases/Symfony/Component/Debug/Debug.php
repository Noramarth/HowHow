<?php

declare(strict_types=1);

namespace Symfony\Component\Debug;

use Symfony\Component\ErrorHandler\Debug as GoodDebugClass;

use function class_alias;
use function class_exists;
use function sprintf;
use function trigger_error;

use const E_USER_DEPRECATED;

if (!class_exists(Debug::class, false)) {
    @trigger_error(sprintf(
        'The %s\Debug class is deprecated since doctrine/persistence 1.3 and will be removed in 2.0.'
        . ' Use \Symfony\Component\ErrorHandler\Debug instead.',
        __NAMESPACE__
    ), E_USER_DEPRECATED);
}

class_alias(
    GoodDebugClass::class,
    __NAMESPACE__ . '\Debug'
);
if (false) {
    /**
     * @deprecated 5.0 Use Symfony\Component\ErrorHandler\Debug
     */
    class Debug extends GoodDebugClass
    {
    }
}
