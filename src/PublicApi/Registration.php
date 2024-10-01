<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\Registration\BeginRegistration;
use Studio15\Loymax\PublicApi\Registration\Request\BeginRegistrationRequest;
use Studio15\Loymax\PublicApi\Registration\Response\BeginRegistrationResponse;
use Studio15\Loymax\PublicApi\Registration\Response\TryFinishRegistrationResponse;
use Studio15\Loymax\PublicApi\Registration\TryFinishRegistration;

/**
 * Registration. Методы для работы с регистрацией клиентов
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/registration/
 */
final readonly class Registration
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Запускает регистрацию клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/registration/#H41743043F44344143A43043544244043543343844144244043044643844EA043A43B43843543D442430
     *
     * @param non-empty-string $login Номер телефона или бонусной карты
     * @param non-empty-string|null $password Пароль для активации карты (при наличии)
     * @param non-empty-string|null $clientIp IP адрес клиента
     *
     * @throws DenormalizeResponseError
     */
    public function beginRegistration(
        string $login,
        ?string $password = null,
        ?string $clientIp = null,
    ): BeginRegistrationResponse {
        $request = new BeginRegistrationRequest(
            login: $login,
            password: $password,
            clientIp: $clientIp,
        );

        $beginRegistration = new BeginRegistration(
            apiClient: $this->apiClient,
        );

        return ($beginRegistration)($request);
    }

    /**
     * Завершает процесс регистрации клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/registration/#H41743043243544044843043544243F44043E44643544144144043543343844144244043044643843843A43B43843543D442430
     *
     * @throws DenormalizeResponseError
     */
    public function tryFinishRegistration(): TryFinishRegistrationResponse
    {
        $tryFinishRegistration = new TryFinishRegistration(
            apiClient: $this->apiClient,
        );

        return ($tryFinishRegistration)();
    }
}
