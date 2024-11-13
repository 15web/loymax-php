<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

use DateTimeImmutable;

/**
 * @api
 * Выпущенная/привязанная карта
 */
final readonly class EmittedCard
{
    /**
     * @param positive-int $id Внутренний идентификатор карты
     * @param CardState $state Статус карты
     * @param non-empty-string $number Номер карты
     * @param non-empty-string $barCode Штрих-код карты
     * @param bool $block Статус блокировки карты (заблокирована/не заблокирована)
     * @param DateTimeImmutable|null $expiryDate Дата истечения срока действия карты (null — без ограничения времени действия)
     * @param CardCategory $cardCategory Описание категории карты
     */
    public function __construct(
        public int $id,
        public CardState $state,
        public string $number,
        public string $barCode,
        public bool $block,
        public ?DateTimeImmutable $expiryDate,
        public CardCategory $cardCategory,
    ) {}
}
