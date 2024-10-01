<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\Notification\Response\UnreadNotificationCount;
use Throwable;

/**
 * Возвращает количество непрочитанных оповещений
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/#H41243E43743244043044943043544243A43E43B43844743544144243243E43E43F43E43243544943543D438439
 */
final readonly class GetNotificationCount
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(): UnreadNotificationCount
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/Notification/Count',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var UnreadNotificationCount $notificationCount */
            $notificationCount = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: UnreadNotificationCount::class,
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $notificationCount;
    }
}
