<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\ContentType;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\Authorization\Request\TwoFactorAuthenticationRequest;
use Studio15\Loymax\Authorization\Response\AccessTokenData;

/**
 * Получение токена доступа по коду подтверждения
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/Token_authorization/
 */
final readonly class ConfirmTwoFactorAuthentication
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(TwoFactorAuthenticationRequest $request): AccessTokenData
    {
        $apiClientRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/authorizationService/token',
            headers: [
                TwoFactorAuthenticationConfig::TWO_FACTOR_AUTH_TOKEN => $request->twoFactorAuthToken,
                'Content-Type' => ContentType::URLENCODED->value,
            ],
            body: [
                'grant_type' => TwoFactorAuthenticationConfig::GRANT_TYPE,
                'password' => $request->code,
            ],
        );

        return $this->apiClient->sendRequest(
            request: $apiClientRequest,
            dataClass: AccessTokenData::class,
        );
    }
}
