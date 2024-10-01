<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Обновленная подписка
 */
final readonly class UpdatedSubscription
{
    /**
     * @param positive-int $typeId Внутренний ID типа подписки
     * @param UpdatedSubscriptionChannel|null $smsNotification Настройка оповещения по SMS
     * @param UpdatedSubscriptionChannel|null $emailNotification Настройка оповещения по email
     * @param UpdatedSubscriptionChannel|null $pushNotification Настройка push-оповещений
     * @param UpdatedSubscriptionChannel|null $viberNotification Настройка оповещения по Viber
     * @param UpdatedSubscriptionChannel|null $socialNetworksNotification Настройка оповещения в социальных сетях
     * @param UpdatedSubscriptionChannel|null $chatBotNotification Настройка оповещения в чат-боте
     */
    public function __construct(
        public int $typeId,
        public ?UpdatedSubscriptionChannel $smsNotification = null,
        public ?UpdatedSubscriptionChannel $emailNotification = null,
        public ?UpdatedSubscriptionChannel $pushNotification = null,
        public ?UpdatedSubscriptionChannel $viberNotification = null,
        public ?UpdatedSubscriptionChannel $socialNetworksNotification = null,
        public ?UpdatedSubscriptionChannel $chatBotNotification = null,
    ) {}
}
