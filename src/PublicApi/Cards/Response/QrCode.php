<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

use DateTimeImmutable;

/**
 * @api
 *
 * QR-код
 */
final readonly class QrCode
{
    /**
     * @param DateTimeImmutable $codeGeneratedDate Дата генерации QR-кода
     * @param non-empty-string $code Значение QR-кода
     * @param positive-int $lifeTime Время жизни QR-кода в секундах
     */
    public function __construct(
        public DateTimeImmutable $codeGeneratedDate,
        public string $code,
        public int $lifeTime,
    ) {}
}
