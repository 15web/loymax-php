<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\User\PhoneNumber\Response\PhoneNumberState;

/**
 * Возвращает информацию о номере телефона клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/?srid=tnpSfw8N#H41243E43743244043044943043544243843D44443E44043C43044643844E43E43D43E43C43544043544243543B43544443E43D43043A43B43843543D442430
 */
final readonly class GetPhoneNumber
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): PhoneNumberState
    {
        $request = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/User/PhoneNumber',
        );

        $response = $this->apiClient->sendRequest($request);

        /** @var PhoneNumberState $phoneNumberState */
        $phoneNumberState = (new CreateSerializer())()->denormalize(
            data: $response->data,
            type: PhoneNumberState::class,
        );

        return $phoneNumberState;
    }
}
