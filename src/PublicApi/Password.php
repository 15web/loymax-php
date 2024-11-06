<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Password\Request\StartResetPasswordRequest;
use Studio15\Loymax\PublicApi\Password\Response\ResetPasswordStarted;
use Studio15\Loymax\PublicApi\Password\StartResetPassword;
use Studio15\Loymax\PublicApi\User\ValueObject\Email;

/**
 * Password. Методы для работы с паролем
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/
 */
final readonly class Password
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Запускает восстановление пароля
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/#H41743043F44344143A43043544243243E44144144243043D43E43243B43543D43843543F43044043E43B44F
     *
     * @param non-empty-string $notifierIdentity Значение нотификатора (номер телефона/email)
     *
     * @throws ApiClientException
     */
    public function startResetPassword(string $notifierIdentity): ResetPasswordStarted
    {
        $request = new StartResetPasswordRequest(
            notifierIdentity: $notifierIdentity,
        );

        $startResetPassword = new StartResetPassword(
            apiClient: $this->apiClient
        );

        return ($startResetPassword)($request);
    }
}
