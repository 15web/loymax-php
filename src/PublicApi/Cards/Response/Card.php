<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

/**
 * @api
 * Карта
 */
final readonly class Card
{
    /**
     * @param positive-int $id
     * @param CardState $state Статус карты
     * @param non-empty-string $number Номер карты
     * @param non-empty-string $barCode Баркод
     * @param bool $block Заблокирована или нет
     * @param non-empty-string|null $expiryDate Дата истечения карты
     * @param CardCategory $cardCategory Информация о категории карты
     * @param Balance $accumulated Информация о полученных за время участия в ПЛ бонусов (требуется в случае, если Партнер не использует функциональность мультивалютных счетов)
     * @param Balance $paid Информация о потраченных за время участия в ПЛ бонусов (требуется в случае, если Партнер не использует функциональность мультивалютных счетов)
     * @param list<Balance> $accumulatedInfo Информация о полученных за время участия в ПЛ бонусов (требуется в случае, если Партнер использует функциональность мультивалютных счетов)
     * @param list<Balance> $paidInfo Информация о потраченных за время участия в ПЛ бонусов (требуется в случае, если Партнер использует функциональность мультивалютных счетов)
     * @param CardActionAccessInfo $cardActionAccessInfo Информация о возможности выполнять действия с картой
     */
    public function __construct(
        public int $id,
        public CardState $state,
        public string $number,
        public string $barCode,
        public bool $block,
        public ?string $expiryDate,
        public CardCategory $cardCategory,
        public Balance $accumulated,
        public Balance $paid,
        public array $accumulatedInfo,
        public array $paidInfo,
        public CardActionAccessInfo $cardActionAccessInfo,
    ) {}
}
