<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Request;

namespace Studio15\Loymax\PublicApi\User\Request;

use Studio15\Loymax\PublicApi\User\Response\SubscriptionExternalId;

/**
 * Фильтр подписок
 */
final readonly class GetSubscriptionRequest
{
    /**
     * @param non-empty-list<SubscriptionExternalId> $subscriptionExternalIds Внешние ID подписок
     */
    public function __construct(
        public array $subscriptionExternalIds,
    ) {}
}
