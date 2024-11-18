<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Password;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Password\Request\StartResetPasswordRequest;
use Studio15\Loymax\PublicApi\Password\Response\ResetPasswordStarted;

/**
 * Запускает восстановление пароля
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/#H41743043F44344143A43043544243243E44144144243043D43E43243B43543D43843543F43044043E43B44F
 */
final readonly class StartResetPassword
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(StartResetPasswordRequest $requestBody): ResetPasswordStarted
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::POST,
            uri: '/publicapi/v1.2/ResetPassword/Start',
            body: $requestBody,
        );

        /** @var ResetPasswordStarted $resetPasswordStarted */
        $resetPasswordStarted = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data,
            type: ResetPasswordStarted::class,
        );

        return $resetPasswordStarted;
    }
}
