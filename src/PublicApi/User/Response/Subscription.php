<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Подписка
 */
final readonly class Subscription
{
    /**
     * @param positive-int $typeId Внутренний ID типа подписки
     * @param non-empty-string $typeName Название типа подписки
     * @param SubscriptionExternalId $externalId Внешний ID типа подписки
     * @param SubscriptionChannel $smsNotification Настройка оповещения по SMS
     * @param SubscriptionChannel $emailNotification Настройка оповещения по email
     * @param SubscriptionChannel $pushNotification Настройка push-оповещений
     * @param SubscriptionChannel $viberNotification Настройка оповещения по Viber
     * @param SubscriptionChannel $socialNetworksNotification Настройка оповещения в социальных сетях
     * @param SubscriptionChannel $chatBotNotification Настройка оповещения в чат-боте
     */
    public function __construct(
        public int $typeId,
        public string $typeName,
        public SubscriptionExternalId $externalId,
        public SubscriptionChannel $smsNotification,
        public SubscriptionChannel $emailNotification,
        public SubscriptionChannel $pushNotification,
        public SubscriptionChannel $viberNotification,
        public SubscriptionChannel $socialNetworksNotification,
        public SubscriptionChannel $chatBotNotification,
    ) {}
}
