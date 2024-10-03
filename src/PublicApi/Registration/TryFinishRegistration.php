<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Registration;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Registration\Response\TryFinishRegistrationResponse;

/**
 * Завершает процесс регистрации клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/registration/#H41743043243544044843043544243F44043E44643544144144043543343844144244043044643843843A43B43843543D442430
 */
final readonly class TryFinishRegistration
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): TryFinishRegistrationResponse
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/Registration/TryFinishRegistration',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        /** @var TryFinishRegistrationResponse $tryFinishRegistration */
        $tryFinishRegistration = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: TryFinishRegistrationResponse::class,
        );

        return $tryFinishRegistration;
    }
}
