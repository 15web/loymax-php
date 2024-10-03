<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;

/**
 * Оформляет подписку на все типы рассылок при регистрации нового клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Subscriptions/#H41E44443E44043C43B44F43544243F43E43443F43844143A44343D43043244143544243843F44B44043044144144B43B43E43A43F44043844043543343844144244043044643843843D43E43243E43343E43A43B43843543D442430
 */
final readonly class ConfirmSubscriptions
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): void
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/Subscriptions/Confirm',
        );

        $this->apiClient->sendRequest($apiRequest);
    }
}
