<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Pushes\Request;

/**
 * Запрос на регистрацию мобильного устройства
 *
 * @internal
 */
final readonly class RegisterRequest
{
    /**
     * @param non-empty-string $token Токен устройства
     * @param PlatformType $platformType Клиентская платформа
     * @param non-empty-string $userAgent Идентификационная строка клиентского приложения
     * @param non-empty-string $deviceId Уникальный идентификатор устройства
     * @param non-empty-string $platformVersion Версия операционной системы устройства
     * @param PushServiceType|null $pushServiceType Сервис уведомлений. Необязательный параметр. Если не будет указано его значение, то будет установлено в соответствии с указанной платформой: Android — Fcm, Ios — Apns, Harmony — HMS
     */
    public function __construct(
        public string $token,
        public PlatformType $platformType,
        public string $userAgent,
        public string $deviceId,
        public string $platformVersion,
        public ?PushServiceType $pushServiceType,
    ) {}
}
