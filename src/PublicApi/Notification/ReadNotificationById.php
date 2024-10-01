<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\Notification\Request\ReadNotificationByIdRequest;
use Studio15\Loymax\PublicApi\Notification\Response\Notification;
use Throwable;

/**
 * Отмечает оповещение как прочитанное
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/#H41E44243C43544743043544243E43F43E43243544943543D43843543A43043A43F44043E44743844243043D43D43E435
 *
 * @internal
 */
final readonly class ReadNotificationById
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(ReadNotificationByIdRequest $request): Notification
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: "/publicapi/v1.2/Notification/{$request->notificationId}/Read",
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var Notification $notification */
            $notification = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: Notification::class,
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $notification;
    }
}
