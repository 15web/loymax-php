<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\Authorization\Request\SendConfirmationCodeRequest;

/**
 * Повторная отправка кода подтверждения
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/Token_authorization/#H41F43E43244243E44043D44B43943743043F44043E44143A43E43443043F43E43444243243544043643443543D43844F
 */
final readonly class SendConfirmationCode
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(SendConfirmationCodeRequest $request): void
    {
        $headers = [
            TwoFactorAuthenticationConfig::TWO_FACTOR_AUTH_TOKEN => $request->twoFactorAuthToken,
        ];

        if ($request->clientIp !== null) {
            $headers['X-Forwarded-For'] = $request->clientIp;
        }

        $apiClientRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/authorizationService/v1.2/auth/SendConfirmationCode',
            headers: $headers,
        );

        $this->apiClient->sendRequest($apiClientRequest);
    }
}
