<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Pushes;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Pushes\Request\RegisterRequest;

/**
 * Отправляет push-токен для регистрации мобильного устройства
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Pushes/#H41E44243F44043043243B44F435442push-44243E43A43543D43443B44F440435433438441442440430446438438A043C43E43143843B44C43D43E43343E44344144244043E439441442432430
 */
final readonly class RegisterDevice
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(RegisterRequest $request): void
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/Pushes',
            body: [
                'token' => $request->token,
                'platformType' => $request->platformType->value,
                'userAgent' => $request->userAgent,
                'deviceId' => $request->deviceId,
                'platformVersion' => $request->platformVersion,
            ],
        );

        $this->apiClient->sendRequest($apiRequest);
    }
}
