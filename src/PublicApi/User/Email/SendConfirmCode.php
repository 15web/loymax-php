<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Email;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;

/**
 * Оформляет повторную отправку кода подтверждения при изменении email
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Email/#H41E44443E44043C43B44F43544243F43E43244243E44043D44344E43E44243F44043043243A44343A43E43443043F43E43444243243544043643443543D43844F43F44043843843743C43543D43543D438438email
 */
final readonly class SendConfirmCode
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): void
    {
        $this->apiClient->sendRequest(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/Email/SendConfirmCode',
        );
    }
}
