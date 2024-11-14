<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Email\Response;

/**
 * Текущее состояние нотификатора
 */
enum NotifierStatus: string
{
    /**
     * Подтвержден
     */
    case Verified = 'Verified';

    /**
     * Не подтвержден
     */
    case Unverified = 'Unverified';
}
