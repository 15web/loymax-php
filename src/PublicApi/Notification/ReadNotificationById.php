<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Notification\Response\Notification;
use Webmozart\Assert\Assert;

/**
 * Отмечает оповещение как прочитанное
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/#H41E44243C43544743043544243E43F43E43243544943543D43843543A43043A43F44043E44743844243043D43D43E435
 */
final readonly class ReadNotificationById
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @param positive-int $notificationId Id оповещения
     *
     * @throws ApiClientException
     */
    public function __invoke(int $notificationId): Notification
    {
        Assert::positiveInteger($notificationId);

        $apiResponse = $this->apiClient->sendRequest(
            method: Method::POST,
            uri: "/publicapi/v1.2/Notification/{$notificationId}/Read",
        );

        /** @var Notification $notification */
        $notification = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: Notification::class,
        );

        return $notification;
    }
}
