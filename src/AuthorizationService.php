<?php

declare(strict_types=1);

namespace Studio15\Loymax;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\Authorization\ConfirmTwoFactorAuthentication;
use Studio15\Loymax\Authorization\IssueAccessToken;
use Studio15\Loymax\Authorization\RefreshAccessToken;
use Studio15\Loymax\Authorization\Request\IssueAccessTokenRequest;
use Studio15\Loymax\Authorization\Request\SendConfirmationCodeRequest;
use Studio15\Loymax\Authorization\Request\TwoFactorAuthenticationRequest;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\Authorization\Response\TwoFactorAuthenticationCodeRequired;
use Studio15\Loymax\Authorization\SendConfirmationCode;

/**
 * @api
 * Сервис авторизации
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/
 */
final readonly class AuthorizationService
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Получение токена доступа по логину и паролю,
     * либо получение кода подтверждения при включенной двухфакторной авторизации
     *
     * При включенной двухфакторной авторизации метод возвращает TwoFactorAuthenticationCodeRequired
     * При авторизации по логину и паролю метод возвращает AccessTokenData
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/Token_authorization/
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/Token_authorization/Authorization_in_Personal_Account_Scheme/
     *
     * @param non-empty-string $username Логин (e-mail, номер телефона или номер карты)
     * @param non-empty-string|null $password Пароль
     * @param non-empty-string|null $clientIp IP адрес клиента
     *
     * @throws ApiClientException
     */
    public function issueAccessToken(
        string $username,
        ?string $password = null,
        ?string $clientIp = null,
    ): AccessTokenData|TwoFactorAuthenticationCodeRequired {
        $issueAccessToken = new IssueAccessToken(
            apiClient: $this->apiClient,
        );

        $request = new IssueAccessTokenRequest(
            username: $username,
            password: $password,
            clientIp: $clientIp,
        );

        return ($issueAccessToken)(
            request: $request,
        );
    }

    /**
     * Повторная отправка кода подтверждения
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/Token_authorization/#H41F43E43244243E44043D44B43943743043F44043E44143A43E43443043F43E43444243243544043643443543D43844F
     *
     * @param non-empty-string $twoFactorAuthToken Разовый токен, полученный при запросе токена доступа
     * @param non-empty-string|null $clientIp IP адрес клиента
     *
     * @throws ApiClientException
     */
    public function sendConfirmationCode(string $twoFactorAuthToken, ?string $clientIp = null): void
    {
        $sendConfirmationCode = new SendConfirmationCode(
            apiClient: $this->apiClient,
        );

        $request = new SendConfirmationCodeRequest(
            twoFactorAuthToken: $twoFactorAuthToken,
            clientIp: $clientIp,
        );

        ($sendConfirmationCode)(
            request: $request,
        );
    }

    /**
     * Получение токена доступа по коду подтверждения
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/Token_authorization/#H41F43E43B44344743543D43843544243E43A43543D43043443E44144244343F43043F43E43A43E43444343F43E43444243243544043643443543D43844F
     *
     * @param non-empty-string $twoFactorAuthToken Разовый токен, полученный при запросе токена доступа
     * @param numeric-string $code Код подтверждения
     *
     * @throws ApiClientException
     */
    public function confirmTwoFactorAuthentication(string $twoFactorAuthToken, string $code): AccessTokenData
    {
        $confirmTwoFactorAuthentication = new ConfirmTwoFactorAuthentication(
            apiClient: $this->apiClient,
        );

        $request = new TwoFactorAuthenticationRequest(
            twoFactorAuthToken: $twoFactorAuthToken,
            code: $code,
        );

        return ($confirmTwoFactorAuthentication)(
            request: $request,
        );
    }

    /**
     * Перевыпуск токена доступа по токену обновления
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/Authorization_examples/Access_and_refresh_tokens/#H41F44043843C43544044B43F43E43B44344743543D43844F44243E43A43543D43E432
     *
     * @param non-empty-string $accessToken Токен доступа, который необходимо обновить
     * @param non-empty-string $refreshToken Токен обновления, полученный при авторизации
     *
     * @throws ApiClientException
     */
    public function refreshAccessToken(string $accessToken, string $refreshToken): AccessTokenData
    {
        $expiredTokenData = new AccessTokenData(
            accessToken: $accessToken,
            tokenType: 'Bearer',
            expiresIn: 1,
            refreshToken: $refreshToken,
        );

        $refreshAccessToken = new RefreshAccessToken(
            apiClient: $this->apiClient,
        );

        return ($refreshAccessToken)(
            expiredTokenData: $expiredTokenData,
        );
    }
}
