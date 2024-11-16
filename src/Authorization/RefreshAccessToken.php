<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Data\ContentType;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\Authorization\Request\RefreshAccessTokenRequest;
use Studio15\Loymax\Authorization\Response\AccessTokenData;

/**
 * Перевыпуск токена доступа по токену обновления
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/Authorization_examples/Access_and_refresh_tokens/
 */
final readonly class RefreshAccessToken
{
    public const GRANT_TYPE = 'refresh_token';

    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(RefreshAccessTokenRequest $requestBody): AccessTokenData
    {
        $headers = [
            'Content-Type' => ContentType::URLENCODED->value,
            'Authorization' => "Bearer {$requestBody->accessToken}",
        ];

        return $this->apiClient->sendRequest(
            method: Method::POST,
            uri: '/authorizationService/token',
            body: $requestBody,
            headers: $headers,
            dataClass: AccessTokenData::class,
        );
    }
}
