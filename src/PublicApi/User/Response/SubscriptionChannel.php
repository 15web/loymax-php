<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * @api
 * Канал для оповещений
 */
final readonly class SubscriptionChannel
{
    /**
     * @param bool $readOnly Доступность канала рассылки для изменения
     * @param bool $selected Подключен ли тип подписки клиенту
     */
    public function __construct(
        public bool $readOnly,
        public bool $selected,
    ) {}
}
