<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Pushes\Request;

/**
 * Запрос на регистрацию мобильного устройства
 *
 * @internal
 *
 * @api
 */
final readonly class RegisterRequest
{
    /**
     * @param non-empty-string $token Токен устройства
     * @param PlatformType $platformType Клиентская платформа
     * @param non-empty-string $userAgent Идентификационная строка клиентского приложения
     * @param non-empty-string $deviceId Уникальный идентификатор устройства
     * @param non-empty-string $platformVersion Версия операционной системы устройства
     */
    public function __construct(
        public string $token,
        public PlatformType $platformType,
        public string $userAgent,
        public string $deviceId,
        public string $platformVersion,
    ) {}
}
