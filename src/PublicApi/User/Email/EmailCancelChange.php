<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Email;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;

/**
 * Отменяет процесс изменения email
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Email/#H41E44243C43543D44F43544243F44043E44643544144143843743C43543D43543D43844Femail
 *
 * @internal
 */
final readonly class EmailCancelChange
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(): void
    {
        $request = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/Email/CancelChange',
        );

        $this->apiClient->sendRequest($request);
    }
}
