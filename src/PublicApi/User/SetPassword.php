<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\PublicApi\User\Request\SetPasswordRequest;

/**
 * Устанавливает пароль клиенту
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/#H42344144243043D43043243B43843243043544243F43044043E43B44C43A43B43843543D442443
 */
final readonly class SetPassword
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(SetPasswordRequest $requestBody): AccessTokenData
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/Password/Set',
            body: $requestBody,
        );

        /** @var AccessTokenData $accessTokenData */
        $accessTokenData = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data,
            type: AccessTokenData::class,
        );

        return $accessTokenData;
    }
}
