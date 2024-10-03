<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification\Response;

/**
 * @api
 * Ответ с количеством непрочитанных оповещений
 */
final readonly class UnreadNotificationCount
{
    /**
     * @param non-negative-int $unReadCount Количество непрочитанных оповещений
     */
    public function __construct(
        public int $unReadCount,
    ) {}
}
