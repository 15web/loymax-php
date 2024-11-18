<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Data\ContentType;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\ApiClient\Exception\BadRequest;
use Studio15\Loymax\Authorization\Request\IssueAccessTokenRequest;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\Authorization\Response\TwoFactorAuthenticationCodeRequired;

/**
 * Получение токена доступа по логину и паролю,
 * либо получение кода подтверждения при включенной двухфакторной авторизации
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/Token_authorization/
 */
final readonly class IssueAccessToken
{
    private const TWO_FACTOR_AUTH_VALIDATION_ERROR = 'TwoFactorAuthenticationCodeRequired';

    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(IssueAccessTokenRequest $requestBody): AccessTokenData|TwoFactorAuthenticationCodeRequired
    {
        $headers = [
            'Content-Type' => ContentType::URLENCODED->value,
        ];

        if ($requestBody->clientIp !== null) {
            $headers['X-Forwarded-For'] = $requestBody->clientIp;
        }

        try {
            $accessTokenData = $this->apiClient->sendRequest(
                method: Method::POST,
                uri: '/authorizationService/token',
                body: $requestBody,
                headers: $headers,
                dataClass: AccessTokenData::class,
            );
        } catch (BadRequest $exception) {
            if ($exception->error === self::TWO_FACTOR_AUTH_VALIDATION_ERROR) {
                return new TwoFactorAuthenticationCodeRequired(
                    twoFactorAuthToken: $exception->apiResponse->getHeaderLine(TwoFactorAuthenticationConfig::TWO_FACTOR_AUTH_TOKEN),
                );
            }

            throw $exception;
        }

        return $accessTokenData;
    }
}
