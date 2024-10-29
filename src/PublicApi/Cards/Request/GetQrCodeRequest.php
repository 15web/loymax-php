<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Request;

/**
 * Запрос на генерацию QR-кода для карты по ее внутреннему идентификатору
 *
 * @internal
 */
final readonly class GetQrCodeRequest
{
    /**
     * @param positive-int $cardId Внутренний идентификатор карты
     */
    public function __construct(
        public int $cardId,
    ) {}
}
