<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\PublicApi\Password\ConfirmResetPassword;
use Studio15\Loymax\PublicApi\Password\Request\ConfirmResetPasswordRequest;
use Studio15\Loymax\PublicApi\Password\Request\StartResetPasswordRequest;
use Studio15\Loymax\PublicApi\Password\Response\ResetPasswordStarted;
use Studio15\Loymax\PublicApi\Password\StartResetPassword;

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
        $requestBody = new StartResetPasswordRequest(
            notifierIdentity: $notifierIdentity,
        );

        $startResetPassword = new StartResetPassword(
            apiClient: $this->apiClient
        );

        return ($startResetPassword)($requestBody);
    }

    /**
     * Отправляет введенный код подтверждения для восстановления пароля
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/#H41E44243F44043043243B44F43544243243243543443543D43D44B43943A43E43443F43E43444243243544043643443543D43844F43443B44F43243E44144144243043D43E43243B43543D43844F43F43044043E43B44F
     *
     * @param non-empty-string $notifierIdentity Значение нотификатора (номер телефона/email)
     * @param non-empty-string $confirmCode Код подтверждения
     * @param non-empty-string $newPassword Новый пароль
     *
     * @throws ApiClientException
     */
    public function confirmResetPassword(
        string $notifierIdentity,
        string $confirmCode,
        string $newPassword,
    ): AccessTokenData {
        $requestBody = new ConfirmResetPasswordRequest(
            notifierIdentity: $notifierIdentity,
            confirmCode: $confirmCode,
            newPassword: $newPassword,
        );

        $confirmResetPassword = new ConfirmResetPassword(
            apiClient: $this->apiClient
        );

        return ($confirmResetPassword)($requestBody);
    }
}
