<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification\Request;

/**
 * Запрос на прочтение оповещения
 *
 * @internal
 */
final readonly class ReadNotificationByIdRequest
{
    /**
     * @param positive-int $notificationId
     */
    public function __construct(
        public int $notificationId,
    ) {}
}
