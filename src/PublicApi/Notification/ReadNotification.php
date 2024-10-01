<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Notification\Response\ReadNotificationCount;

/**
 * Отмечает все оповещения прочитанными
 *
 * @internal
 */
final readonly class ReadNotification
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(): ReadNotificationCount
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/Notification/Read',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        /** @var non-negative-int $readCount */
        $readCount = $apiResponse->data;

        return new ReadNotificationCount(
            readCount: $readCount,
        );
    }
}
