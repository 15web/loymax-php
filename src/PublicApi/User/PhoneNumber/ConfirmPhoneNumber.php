<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\User\PhoneNumber\Request\ConfirmPhoneRequest;
use Throwable;

/**
 * Завершает процесс привязки номера телефона
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/#H41743043243544044843043544243F44043E44643544144143F44043843244F43743A43843D43E43C435440430A044243543B43544443E43D430
 */
final readonly class ConfirmPhoneNumber
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(ConfirmPhoneRequest $request): AccessTokenData
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/PhoneNumber/Confirm',
            body: [
                'confirmCode' => $request->confirmCode,
                'password' => $request->password,
            ],
        );

        $response = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var AccessTokenData $accessTokenData */
            $accessTokenData = (new CreateSerializer())()->denormalize(
                data: $response->data,
                type: AccessTokenData::class,
            );
        } catch (Throwable $t) {
            throw new DenormalizeResponseError(previous: $t);
        }

        return $accessTokenData;
    }
}
