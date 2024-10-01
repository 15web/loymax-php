<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Обновленный канал для оповещения
 */
final readonly class UpdatedSubscriptionChannel
{
    /**
     * @param bool $selected Подключен ли тип подписки клиенту
     */
    public function __construct(public bool $selected) {}
}
