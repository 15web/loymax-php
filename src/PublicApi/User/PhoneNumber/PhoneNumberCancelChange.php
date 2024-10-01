<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;

/**
 * Отменяет процесс привязки номера телефона
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/#H41E44243C43543D44F43544243F44043E44643544144143F44043843244F43743A43843D43E43C43544043044243543B43544443E43D430
 */
final readonly class PhoneNumberCancelChange
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(): void
    {
        $request = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/PhoneNumber/CancelChange',
        );

        $this->apiClient->sendRequest($request);
    }
}
