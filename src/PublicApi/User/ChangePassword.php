<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\PublicApi\User\Request\ChangePasswordRequest;

/**
 * Обновляет пароль клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/#H41E43143D43E43243B44F43544243F43044043E43B44C43A43B43843543D442430
 */
final readonly class ChangePassword
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(ChangePasswordRequest $request): AccessTokenData
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/Password/Change',
            body: [
                'oldPassword' => $request->oldPassword,
                'newPassword' => $request->newPassword,
            ]
        );

        $apiResponse = $this->apiClient->sendRequest(
            request: $apiRequest
        );

        /** @var AccessTokenData $accessTokenData */
        $accessTokenData = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data,
            type: AccessTokenData::class,
        );

        return $accessTokenData;
    }
}
