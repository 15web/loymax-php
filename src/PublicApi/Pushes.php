<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\PublicApi\Pushes\RegisterDevice;
use Studio15\Loymax\PublicApi\Pushes\Request\PlatformType;
use Studio15\Loymax\PublicApi\Pushes\Request\RegisterRequest;

/**
 * Pushes. Методы для работы с push-уведомлениями
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Pushes/
 */
final readonly class Pushes
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Отправляет push-токен для регистрации мобильного устройства
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Pushes/#H41E44243F44043043243B44F435442push-44243E43A43543D43443B44F440435433438441442440430446438438A043C43E43143843B44C43D43E43343E44344144244043E439441442432430
     *
     * @param non-empty-string $token Токен устройства
     * @param PlatformType $platformType Клиентская платформа
     * @param non-empty-string $userAgent Идентификационная строка клиентского приложения
     * @param non-empty-string $deviceId Уникальный идентификатор устройства
     * @param non-empty-string $platformVersion Версия операционной системы устройства
     */
    public function registerDevice(
        string $token,
        PlatformType $platformType,
        string $userAgent,
        string $deviceId,
        string $platformVersion,
    ): void {
        $request = new RegisterRequest(
            token: $token,
            platformType: $platformType,
            userAgent: $userAgent,
            deviceId: $deviceId,
            platformVersion: $platformVersion,
        );

        $register = new RegisterDevice(
            apiClient: $this->apiClient,
        );

        ($register)(
            request: $request,
        );
    }
}
