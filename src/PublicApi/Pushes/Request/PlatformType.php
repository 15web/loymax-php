<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Pushes\Request;

/**
 * Клиентская платформа
 */
enum PlatformType: string
{
    case Android = 'Android';

    case Ios = 'Ios';

    case Harmony = 'Harmony';
}
