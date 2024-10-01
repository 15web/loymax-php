<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Data;

/**
 * Тип контента
 */
enum ContentType: string
{
    case JSON = 'application/json';

    case URLENCODED = 'application/x-www-form-urlencoded';
}
