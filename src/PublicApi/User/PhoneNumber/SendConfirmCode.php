<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;

/**
 * Повторно отправляет код подтверждения на новый номер телефона
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/?srid=tnpSfw8N#H41F43E43244243E44043D43E43E44243F44043043243B44F43544243A43E434A043F43E43444243243544043643443543D43844F43D43043D43E43244B43943D43E43C43544044243543B43544443E43D430
 *
 * @internal
 */
final readonly class SendConfirmCode
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(): void
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/PhoneNumber/SendConfirmCode',
        );

        $this->apiClient->sendRequest($apiRequest);
    }
}
