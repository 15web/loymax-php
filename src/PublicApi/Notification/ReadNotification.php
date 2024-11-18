<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Notification\Response\ReadNotificationCount;

/**
 * Отмечает все оповещения прочитанными
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/#H41E44243C43544743043544243244143543E43F43E43243544943543D43844F43F44043E44743844243043D43D44B43C438
 */
final readonly class ReadNotification
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): ReadNotificationCount
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::POST,
            uri: '/publicapi/v1.2/Notification/Read',
        );

        /** @var non-negative-int $readCount */
        $readCount = $apiResponse->data;

        return new ReadNotificationCount(
            readCount: $readCount,
        );
    }
}
