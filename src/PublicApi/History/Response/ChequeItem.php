<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * Товар в чеке
 */
final readonly class ChequeItem
{
    /**
     * @param positive-int $positionId Идентификатор позиции чека
     * @param non-empty-string $description Наименование
     * @param float $amount Стоимость
     * @param float $count Количество
     * @param non-empty-string|null $unit Единица измерения
     */
    public function __construct(
        public int $positionId,
        public string $description,
        public float $amount,
        public float $count,
        public ?string $unit = null,
    ) {}
}
