<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

/**
 * @api
 * Информация о возможности выпуска виртуальной карты
 */
final readonly class GetEmitVirtualResponse
{
    /**
     * @param non-negative-int $currentCountOfVirtualCards Текущее число виртуальных карт
     * @param bool $isVirtualCardEmissionAllowed Признак возможности выпуска виртуальной карты
     */
    public function __construct(
        public int $currentCountOfVirtualCards,
        public bool $isVirtualCardEmissionAllowed,
    ) {}
}
