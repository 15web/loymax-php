<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification\Response;

/**
 * Ответ с количеством прочитанных оповещений
 */
final readonly class ReadNotificationCount
{
    /**
     * @param non-negative-int $readCount Количество прочитанных оповещений
     */
    public function __construct(
        public int $readCount,
    ) {}
}
