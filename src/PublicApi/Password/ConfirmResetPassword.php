<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Password;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\PublicApi\Password\Request\ConfirmResetPasswordRequest;

/**
 * Отправляет введенный код подтверждения для восстановления пароля
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/#H41E44243F44043043243B44F43544243243243543443543D43D44B43943A43E43443F43E43444243243544043643443543D43844F43443B44F43243E44144144243043D43E43243B43543D43844F43F43044043E43B44F
 */
final readonly class ConfirmResetPassword
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(ConfirmResetPasswordRequest $request): AccessTokenData
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/ResetPassword/Confirm',
            body: [
                'notifierIdentity' => $request->notifierIdentity,
                'confirmCode' => $request->confirmCode,
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
